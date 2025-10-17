<?php

namespace App\Http\Controllers;

use App\Models\NoticeBoard;
use App\Models\Utility;
use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notice_text = Utility::where('key', 'notice-board')->value('value');
        $notices = NoticeBoard::all();
       
        return view('notice-board.index', compact('notices', 'notice_text'));
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
    // public function store(Request $request)
    // {
    //     $noticeboard = NoticeBoard::create([
    //         'date' => $request->date,
    //         'description' => $request->description,
    //         'link' => $request->link,
    //         'files' => null,
    //         'remark' => $request->remark,
    //     ]);

    //     $files = [];

    //     if ($request->hasFile('image')) {
    //         $folderPath = public_path("assets/noticeboard/{$noticeboard->id}");

    //         if (!file_exists($folderPath)) {
    //             mkdir($folderPath, 0777, true);
    //         }
    //         foreach ($request->file('image') as $file) {
    //             $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
    //             $file->move($folderPath, $filename);
    //             $files[] = "assets/noticeboard/{$noticeboard->id}/{$filename}";
    //         }
    //     }

    //     $noticeboard->update([
    //         'files' => implode(',', $files),
    //     ]);

    //     return redirect()->back()->with('success', 'Notice added successfully!');
    // }
    
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

    public function store(Request $request)
    {
        $noticeboard = NoticeBoard::create([
            'date'        => $request->date,
            'description' => $request->description,
            'link'        => $request->link,
            'files'       => null,
            'remark'      => $request->remark,
        ]);

        $files = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $s3Key = "noticeboard/{$noticeboard->id}/{$filename}";

                // Save to temp file first
                $tmpFile = tempnam(sys_get_temp_dir(), 'nbimg');
                $file->move(dirname($tmpFile), basename($tmpFile));

                // Upload to S3
                $s3Url = $this->uploadToS3($tmpFile, $s3Key);

                // Cleanup temp file
                unlink($tmpFile);

                if ($s3Url) {
                    $files[] = $s3Key;
                }
            }
        }

        $noticeboard->update([
            'files' => implode(',', $files),
        ]);

        return redirect()->back()->with('success', 'Notice added successfully!');
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
    public function destroy($id)
    {
        $notice = Noticeboard::findOrFail($id);
        // $folderPath = public_path("assets/noticeboard/{$id}");

        // if (File::exists($folderPath)) {
        //     File::deleteDirectory($folderPath);
        // }

        $notice->delete();

        return redirect()->route('notice.board.index')->with('success', 'Notice deleted successfully.');
    }
}
