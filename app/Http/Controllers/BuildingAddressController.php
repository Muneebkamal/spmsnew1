<?php

namespace App\Http\Controllers;

use App\Models\buildingAddress;
use App\Models\Utility;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class BuildingAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        return view('buildings.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = BuildingAddress::select([
                'id',
                'building',
                'district',
                'address',
                'address_chinese',
                'usage',
                'year_of_completion',
                'property_type',
                'title',
                'management_company',
                'developers',
                'transportation',
                'floor',
                'floor_area',
                'height',
                'air_con_system',
                'lifts',
                'parking',
                'carpark'
            ]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('building.edit', $row->id);
                    $deleteUrl = route('building.destroy', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-primary mb-1">Edit</a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $path = $request->file('file')->getRealPath();
        $data = Excel::toArray([], $path);

        // First sheet only
        foreach ($data[0] as $index => $row) {
            if ($index === 0) continue; // skip header row

            buildingAddress::create([
                'building'       => $row[0] ?? null,
                'district'        => $row[1] ?? null,
                'address'         => $row[2] ?? null,
                'usage'           => $row[4] ?? null,
                'year'            => $row[6] ?? null,
                'floor'           => $row[11] ?? null,
                'ceiling_height'  => $row[13] ?? null,
                'air_con_system'  => $row[14] ?? null,
                'customer_lift'   => $row[15] ?? null,
                'carpark'        => $row[17] ?? null,
            ]);
        }

        return back()->with('success', 'Building addresses imported successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $districts = explode(',', Utility::where('key', 'district')->value('value'));
        $usage = explode(',', Utility::where('key', 'usage')->value('value'));
        return view('buildings.create', compact('districts', 'usage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        buildingAddress::create([
            'building' => $request->building,
            'district' => $request->district,
            'address' => $request->address,
            'address_chinese' => $request->address_chinese,
            'usage' => is_array($request->usage) ? implode(',', $request->usage) : $request->usage,
            'property_type' => $request->property_type,
            'year_of_completion' => $request->year_of_completion,
            'title' => $request->title,
            'management_company' => $request->management_company,
            'transportation' => $request->transportation,
            'developers' => $request->developers,
            'floor' => $request->floor,
            'floor_area' => $request->floor_area,
            'height' => $request->height,
            'air_con_system' => $request->air_con_system,
            'lifts' => $request->lifts,
            'parking' => $request->parking,
            'carpark' => $request->carpark,
        ]);

        return redirect()->back()->with('success', 'Building added successfully!');
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
        $building = BuildingAddress::findOrFail($id);
        $districts = explode(',', Utility::where('key', 'district')->value('value'));
        $usage = explode(',', Utility::where('key', 'usage')->value('value'));
        return view('buildings.edit', compact('building', 'districts', 'usage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $building = BuildingAddress::findOrFail($id);
        $building->update([
            'building' => $request->building,
            'district' => $request->district,
            'address' => $request->address,
            'address_chinese' => $request->address_chinese,
            'usage' => is_array($request->usage) ? implode(',', $request->usage) : $request->usage,
            'property_type' => $request->property_type,
            'year_of_completion' => $request->year_of_completion,
            'title' => $request->title,
            'management_company' => $request->management_company,
            'transportation' => $request->transportation,
            'developers' => $request->developers,
            'floor' => $request->floor,
            'floor_area' => $request->floor_area,
            'height' => $request->height,
            'air_con_system' => $request->air_con_system,
            'lifts' => $request->lifts,
            'parking' => $request->parking,
            'carpark' => $request->carpark,
        ]);

        return redirect()->route('building.address')->with('success', 'Building updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $building = BuildingAddress::findOrFail($id);
        $building->delete();

        return response()->json(['success' => true, 'message' => 'Building deleted successfully!']);
    }
}
