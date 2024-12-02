<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Stage;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'vehicle_id' => 'exists:vehicles,id',
            'placa' => 'required|regex:/^[A-Z]{3}\d{1}[A-Z\d]{1}\d{2}$/',
            'carrier_id'=> 'exists:carriers,id',
            'user_id'=> 'exists:users,id',
            'parking_space_id' => 'nullable|exists:parking_spaces,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $requestAll = $request->all();

        $requestAll['id'] = $request->get('id', null);

        $vehicle = Vehicle::updateOrCreate(
            [
                'placa' => $requestAll['placa']
            ],
            [
                'vehicle_type_id' => $requestAll['vehicle_type_id'],
                'driver_id' => $requestAll['driver_id'],
            ]
        );

        Booking::updateOrCreate(
            [
                'id' => $requestAll['id']
            ],
            [
                'booking_dt' => $requestAll['booking_dt'],
                'vehicle_id' => $vehicle->id,
                'carrier_id' => $requestAll['carrier_id'],
                'user_id' => Auth::id(),
                'stage_id' => Stage::where('position', 0)->first()->id,
                'parking_space_id' => $requestAll['parking_space_id'],
            ]
        );

        $bookings = Booking::with('vehicle', 'stage', 'carrier', 'parkingSpace')->get();

        return response()->json($bookings, 200);
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

    public function nextStage(Booking $booking){
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

        $bookings = Booking::with('vehicle', 'stage', 'carrier', 'parkingSpace')->get();

        return response()->json($bookings, $stts);
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

        $bookings = Booking::with('vehicle', 'stage', 'carrier', 'parkingSpace')->get();

        return response()->json($bookings, $stts);
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

        $bookings = Booking::with('vehicle', 'stage', 'carrier', 'parkingSpace')->get();

        return response()->json($bookings, $stts);
    }

    public function getBookings(){
        $bookings = Booking::with('vehicle', 'stage', 'carrier', 'parkingSpace')->get();

        return response()->json($bookings);
    }
}
