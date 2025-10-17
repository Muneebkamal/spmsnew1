<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\PhotoAi;
use Illuminate\Support\Facades\Log;
use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiImageController extends Controller
{
    public function uploadToS3($localFilePath, $s3Key)
    {
        $s3 = new S3Client([
            'region'  => 'ap-southeast-2',
            'version' => 'latest',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        try {
            $s3->putObject([
                'Bucket'      => env('AWS_BUCKET'),
                'Key'         => $s3Key,
                'SourceFile'  => $localFilePath,
                'ContentType' => mime_content_type($localFilePath),
            ]);

            // Return only the S3 key (not full URL)
            return $s3Key;

        } catch (AwsException $e) {
            dd($e->getMessage());
            Log::error("S3 upload failed: " . $e->getMessage());
            return false;
        }
    }

    public function s3_get_contents($photo) {
        $s3 = new S3Client([
            'region' => 'ap-southeast-2',
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
        
        // Define bucket name and object key
        $bucket = 'spms-property';
        $key = $photo->image; // e.g. 'images/myimage.jpg'
        
        // Get the object
        $result = $s3->getObject([
            'Bucket' => $bucket,
            'Key' => $key,
        ]);
        
        // Get the body (content of the image)
        $content = $result['Body']->getContents();
        
        // Dump the content (may be binary if it's an image)
        return $content;
    }

    public function generate(Request $request)
    {
        $photoId = $request->input('photo_id');
        $photo   = Photo::find($photoId);

        if (!$photo) {
            return response()->json(['status' => 'error', 'message' => 'Photo not found'], 404);
        }

        $folder_code = $photo->code;

        // Extract original filename from S3 key
        $originalName = pathinfo($photo->image, PATHINFO_FILENAME);
        $aiFileName   = $originalName . "_ai.webp";
        $s3Key        = "{$folder_code}/{$aiFileName}";

        // Stability AI API
        $url    = 'https://api.stability.ai/v2beta/stable-image/control/structure';
        $apiKey = env('STABILITY_API_KEY');

        $data = [
            'prompt'             => "add office furniture, some chairs and tables, modern Design, keep walls original structure, keep original room length",
            'negative_prompt'    => 'dont change camera angle, dont change room dimensions,dont change wall boundaries ,dont change floor length, dont change ceiling, dont change structure',
            'control_strength'   => 0.9,
            'style_preset'       => '3d-model',
            'sampling_method'    => 'Euler a',
            'sampling_steps'     => 40,
            'cfg_scale'          => 10,
            'denoising_strength' => 0.5,
            'output_format'      => 'webp',
        ];

        try {
            // Build full URL for S3 image
            $baseUrl = 'https://spms-property.s3.ap-southeast-2.amazonaws.com';
            $imageUrl = $baseUrl . '/' . $photo->image;

            // Fetch image from S3 for AI processing
            $imageContents = $this->s3_get_contents($photo);
            
            // Send request to Stability AI
            $response = Http::retry(3, 5000)
                ->timeout(120)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Accept'        => 'image/*',
                ])
                ->attach('image', $imageContents, basename($photo->image))
                ->post($url, $data);

            if ($response->failed()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'AI API error',
                    'raw'     => $response->body()
                ], 500);
            }

            // Save AI image to temporary file
            $tmpFile = tempnam(sys_get_temp_dir(), 'aiimg');
            file_put_contents($tmpFile, $response->body());

            // Upload AI image to S3
            $s3KeySaved = $this->uploadToS3($tmpFile, $s3Key);

            // Cleanup temporary file
            unlink($tmpFile);

            if (!$s3KeySaved) {
                return response()->json(['status' => 'error', 'message' => 'Failed to upload AI image to S3'], 500);
            }

            // Save AI image record in database (store only the S3 key)
            PhotoAi::create([
                'photo_id' => $photo->id,
                'img_name' => $s3KeySaved,  
                'preset'   => '3d-model',
                'style'    => 'modern office',
                'prompt'   => 'Interior Decor',
                'code'     => $folder_code,
            ]);

            // Build full URL for response
            $fullUrl = $baseUrl . '/' . $s3KeySaved;

            return response()->json([
                'status'  => 'success',
                'message' => 'AI image generated',
                'url'     => $fullUrl
            ]);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'API timeout or unreachable',
                'error'   => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unexpected error',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    // public function generate(Request $request)
    // {
    //     $photoId = $request->input('photo_id');

    //     $photo = Photo::find($photoId);

    //     if (!$photo) {
    //         return response()->json(['status' => 'error', 'message' => 'Photo not found'], 404);
    //     }

    //     $folder_code = $photo->code;
    //     $uuid        = $photo->uuid;
    //     $imagePath = public_path($photo->image);

    //     if (!file_exists($imagePath)) {
    //         return response()->json(['status' => 'error', 'message' => 'File not found'], 404);
    //     }

    //     $aiFileName = "{$uuid}_a_i.webp";
    //     $aiSavePath = public_path("properties/{$folder_code}/{$aiFileName}");

    //     // If already exists
    //     if (file_exists($aiSavePath)) {
    //         return response()->json(['status' => 'exist', 'message' => 'AI image already exists']);
    //     }

    //     // Stability API
    //     $url    = 'https://api.stability.ai/v2beta/stable-image/control/structure';
    //     $apiKey = "sk-lGnLTTdaybgJgCRz3FTvKyYf0HbZrCxMuEelY2bGg2ekKoaU";

    //     $data = [
    //         'prompt'             => "add office furniture, some chairs and tables, modern Design, keep walls original structure, keep original room length",
    //         'negative_prompt'    => 'dont change camera angle, dont change room dimensions,dont change wall boundaries ,dont change floor length, dont change ceiling, dont change structure',
    //         'control_strength'   => 0.9,
    //         'style_preset'       => '3d-model',
    //         'sampling_method'    => 'Euler a',
    //         'sampling_steps'     => 40,
    //         'cfg_scale'          => 10,
    //         'denoising_strength' => 0.5,
    //         'output_format'      => 'webp',
    //     ];

    //     try {
    //         $response = Http::retry(3, 5000)
    //             ->timeout(120)
    //             ->withHeaders([
    //                 'Authorization' => 'Bearer ' . $apiKey,
    //                 'Accept'        => 'image/*',
    //             ])->attach(
    //                 'image', file_get_contents($imagePath), basename($imagePath)
    //             )->post($url, $data);

    //         if ($response->failed()) {
    //             return response()->json([
    //                 'status'  => 'error',
    //                 'message' => 'API error',
    //                 'raw'     => $response->body()
    //             ], 500);
    //         }

    //         file_put_contents($aiSavePath, $response->body());

    //         PhotoAi::create([
    //             'photo_id' => $photo->id,
    //             'img_name' => "properties/{$folder_code}/{$aiFileName}",
    //             'preset'   => '3d-model',
    //             'style'    => 'modern office',
    //             'prompt'   => 'Interior Decor',
    //             'code'     => $folder_code,
    //         ]);

    //         return response()->json(['status' => 'success', 'message' => 'AI image generated']);
    //     } catch (\Illuminate\Http\Client\ConnectionException $e) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'API timeout or unreachable',
    //             'error'   => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
