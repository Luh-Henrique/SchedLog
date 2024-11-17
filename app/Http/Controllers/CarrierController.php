<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CarrierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carriers = Carrier::get();

        return Inertia::render('Carrier/Index', [
            'carriers' => $carriers
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
            'cnpj' => 'required|regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/|unique:carriers,cnpj',
            'cep' => 'required|string|regex:/^\d{5}-\d{3}$/',
            'address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $requestAll = $request->all();

        $requestAll['id'] = $request->get('id');

        Carrier::updateOrCreate(
            [
                'id' => $requestAll['id']
            ],
            [
                'name' => $requestAll['name'],
                'cnpj' => $requestAll['cnpj'],
                'user_id' => Auth::id(),
                'cep' => $requestAll['cep'],
                'address' => $requestAll['address'],
            ]
        );

        $carriers = Carrier::get();

        return response()->json($carriers, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Carrier $carrier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carrier $carrier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carrier $carrier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carrier $carrier)
    {
        $carrier->delete();

        $carriers = Carrier::get();

        return response()->json($carriers, 200);
    }
}
