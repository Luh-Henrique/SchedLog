<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index(){
        return Inertia::render('Report/Index');
    }

    public function getBookingsByStage()
    {
        $data = DB::table('bookings')
        ->select('stages.desc as stage_desc', DB::raw('COUNT(*) as total'))
        ->join('stages', 'stages.id', '=', 'bookings.stage_id')
        ->groupBy('stages.desc')
        ->orderBy('total', 'desc')
        ->get()->toArray();


        return response()->json($data);
    }

    public function getBookingsByCarrier()
    {
        $data = DB::table('bookings')
            ->select('carriers.name as carrier_name', DB::raw('COUNT(*) as total'))
            ->join('carriers', 'carriers.id', '=', 'bookings.carrier_id')
            ->groupBy('carriers.name')
            ->orderBy('total', 'desc')
            ->get()->toArray();

        return response()->json($data);
    }

    public function getBookingsByVehicle()
    {
        $data = DB::table('bookings')
            ->select('vehicles.placa as vehicle_placa', DB::raw('COUNT(*) as total'))
            ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
            ->groupBy('vehicle_placa')
            ->orderBy('total', 'desc')
            ->get()->toArray();

        return response()->json($data);
    }
}

