<?php

namespace App\Http\Controllers;

use App\Models\buildingAddress;
use App\Models\Property;
use App\Models\Utility;
use Illuminate\Http\Request;

class UtilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('utilities.index');
    }

    public function getValues($key) {
        $values = explode(',', Utility::where('key', $key)->value('value'));
        return response()->json($values);
    }
    
    public function addValue(Request $request) {
        $utility = Utility::where('key', $request->key)->first();
        $values = explode(',', $utility->value);
        $values[] = $request->value;
        $utility->value = implode(',', $values);
        $utility->save();
        return response()->json(['success' => true]);
    }
    
    public function editValue(Request $request) {
        $utility = Utility::where('key', $request->key)->first();
        $values = explode(',', $utility->value);
        $values[$request->index] = $request->value;
        $utility->value = implode(',', $values);
        $utility->save();
        return response()->json(['success' => true]);
    }
    
    public function deleteValue(Request $request) {
        $utility = Utility::where('key', $request->key)->first();
        $values = explode(',', $utility->value);
        $deleteValue = trim($values[$request->index]);
        unset($values[$request->index]);
        $utility->value = implode(',', array_values($values));
        $utility->save();

        // Now update all properties where this column exists and contains the deleted value
        $column = $request->key;

        // Process properties in chunks (for performance on large data)
        Property::whereNotNull($column)->chunk(100, function ($properties) use ($column, $deleteValue) {
            foreach ($properties as $property) {
                $propValues = array_filter(explode(',', $property->{$column}));
                $propValues = array_map('trim', $propValues);

                if (in_array($deleteValue, $propValues)) {
                    $propValues = array_diff($propValues, [$deleteValue]);
                    $property->{$column} = implode(',', $propValues);
                    $property->save();
                }
            }
        });

        return response()->json(['success' => true]);
    }
    
    public function updateAgentLimit(Request $request)
    {
        Utility::updateOrInsert(
            ['key' => 'agent_limit_per_day'],
            ['value' => $request->value]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Agent limit updated successfully!',
            'value' => $request->value
        ]);
    }

    public function getAgentLimit()
    {
        $limit = Utility::where('key', 'agent_limit_per_day')
            ->value('value');

        return response()->json(['value' => $limit]);
    }

    public function saveDistricts()
    {
        // Get all non-null districts from building_addresses
        $districtsFromBuildings = buildingAddress::whereNotNull('district')
            ->pluck('district')
            ->unique()
            ->toArray();

        // Get or create the utility record for 'district'
        $utility = Utility::firstOrCreate(['key' => 'district']);
        $currentDistricts = $utility->value ? explode(',', $utility->value) : [];

        // Merge new districts and keep unique
        $newDistricts = array_unique(array_merge($currentDistricts, $districtsFromBuildings));

        // Save back as comma-separated string
        $utility->value = implode(',', $newDistricts);
        $utility->save();

        return response()->json([
            'message' => 'Districts updated successfully',
            'districts' => $newDistricts
        ]);
    }

    public function getNoticeBoard()
    {
        $value = Utility::where('key', 'notice-board')->value('value');
        return response()->json(['value' => $value]);
    }

    public function saveNoticeBoard(Request $request)
    {
        Utility::updateOrInsert(
            ['key' => 'notice-board'],
            [
                'value' => $request->notice_board,
                'updated_at' => now()
            ]
        );

        return response()->json(['success' => true, 'message' => 'Notice Board updated successfully!']);
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
