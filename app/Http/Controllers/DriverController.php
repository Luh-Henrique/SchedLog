<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::get();

        return Inertia::render('Driver/Index', [
            'drivers' => $drivers
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
            'name' => 'required|string|max:255',
            'cnh' => 'required|regex:/^\d{3}\s?\d{3}\s?\d{3}\s?\d{2}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $requestAll = $request->all();

        $requestAll['id'] = $request->get('id', null);

        Driver::updateOrCreate(
            [
                'id' => $requestAll['id']
            ],
            [
                'name' => $requestAll['name'],
                'cnh' => $requestAll['cnh'],
            ]
        );

        $drivers = Driver::get();

        return response()->json($drivers, 200);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();

        $drivers = Driver::get();

        return response()->json($drivers, 200);
    }
}
