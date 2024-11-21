<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class VehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicleTypes = VehicleType::orderBy('desc', 'asc')->get();

        return Inertia::render('VehicleType/Index', [
            'vehicleTypes' => $vehicleTypes
        ]);
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
        $validator = Validator::make($request->all(), [
            'desc' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $requestAll = $request->all();

        $requestAll['id'] = $request->get('id', null);

        if (isset($requestAll['id'])) {
            // Update existing record
            VehicleType::updateOrCreate(
                ['id' => $requestAll['id']],
                ['desc' => $requestAll['desc']]
            );
        } else {
            VehicleType::create([
                'desc' => $requestAll['desc']
            ]);
        }

        $vehicleTypes = VehicleType::get();

        return response()->json($vehicleTypes, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleType $vehicleType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();

        $vehicleTypes = VehicleType::get();

        return response()->json($vehicleTypes, 200);
    }
}
