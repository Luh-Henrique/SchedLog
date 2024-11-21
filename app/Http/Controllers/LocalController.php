<?php

namespace App\Http\Controllers;

use App\Models\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class LocalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locals = Local::get();

        return Inertia::render('Local/Index', [
            'locals' => $locals
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

        $requestAll['id'] = $request->get('id', null);

        Local::updateOrCreate(
            [
                'id' => $requestAll['id']
            ],
            [
                'name' => $requestAll['name'],
                'user_id' => Auth::id(),
                'cep' => $requestAll['cep'],
                'address' => $requestAll['address'],
            ]
        );

        $locals = Local::get();

        return response()->json($locals, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Local $local)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Local $local)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Local $local)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Local $local)
    {
        $local->delete();

        $locals = Local::get();

        return response()->json($locals, 200);
    }
}
