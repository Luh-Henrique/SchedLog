<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
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
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'exists:vehicles',
            'carrier_id'=> 'exists:carriers',
            'user_id'=> 'exists:users',
            'stage_id'=> 'exists:stages',
            'parking_space_id' => 'exists:parking_spaces'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function nextStage($booking){
        $stage = $booking->getNextStage();
        if($stage){
            $booking->update([
                'stage_id' => $stage->id
            ]);

            $message = 'Avançou com sucesso'; $stts = 200;
        }
        else{
            $message = 'Erro ao Avançar'; $stts = 500;
        }

        return response()->json(['message' => $message, 'stts' => $stts]);
    }

    public function previousStage(Booking $booking){
        $stage = $booking->getPreviousStage();
        if($stage){
            $booking->update([
                'stage_id' => $stage->id
            ]);

            $message = 'Retrocedeu com sucesso'; $stts = 200;
        }
        else{
            $message = 'Erro ao Retroceder'; $stts = 500;
        }

        return response()->json(['message' => $message, 'stts' => $stts]);
    }

    public function cancel(Booking $booking){
        $stage = $booking->getCancelStage();
        if($stage){
            $booking->update([
                'stage_id' => $stage->id
            ]);

            $message = 'Cancelado com sucesso'; $stts = 200;
        }
        else{
            $message = 'Erro ao cancelar'; $stts = 500;
        }

        return response()->json(['message' => $message, 'stts' => $stts]);
    }

    public function getBookings(){
        $bookings = Booking::get();

        return response()->json($bookings);
    }
}
