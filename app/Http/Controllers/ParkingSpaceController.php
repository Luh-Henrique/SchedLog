<?php

namespace App\Http\Controllers;

use App\Models\Local;
use App\Models\ParkingSpace;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ParkingSpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parkingSpaces = ParkingSpace::with('local')->get()->map(function ($parkingSpace) {
            $parkingSpace->vehicleTypes = VehicleType::whereIn('id', $parkingSpace->vehicle_types)->get();
            return $parkingSpace;
        });

        $locals = Local::orderBy('name')->get();
        $vehicleTypes = VehicleType::orderBy('desc')->get();

        return Inertia::render('ParkingSpace/Index', [
            'parkingSpaces' => $parkingSpaces,
            'locals' => $locals,
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
            'local_id'=> 'exists:locals,id',
            'vehicle_types' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $requestAll = $request->all();

        $requestAll['id'] = $request->get('id', null);

        ParkingSpace::updateOrCreate(
            [
                'id' => $requestAll['id']
            ],
            [
                'desc' => $requestAll['desc'],
                'local_id' => $requestAll['local_id'],
                'vehicle_types' => $requestAll['vehicle_types'],
            ]
        );

        $parkingSpaces = ParkingSpace::with('local')->get()->map(function ($parkingSpace) {
            $parkingSpace->vehicleTypes = VehicleType::whereIn('id', $parkingSpace->vehicle_types)->get();
            return $parkingSpace;
        });

        return response()->json($parkingSpaces, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ParkingSpace $parkingSpace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParkingSpace $parkingSpace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParkingSpace $parkingSpace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParkingSpace $parkingSpace)
    {
        $parkingSpace->delete();

        $parkingSpaces = ParkingSpace::with('local')->get()->map(function ($parkingSpace) {
            $parkingSpace->vehicleTypes = VehicleType::whereIn('id', $parkingSpace->vehicle_types)->get();
            return $parkingSpace;
        });

        return response()->json($parkingSpaces, 200);
    }
}
