<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Driver;
use App\Models\ParkingSpace;
use App\Models\Stage;
use App\Models\VehicleType;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(){
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function dashboard(){
        $stages = Stage::orderBy('position', 'asc')->get();
        $carriers = Carrier::orderBy('name')->get();
        $parkingSpaces = ParkingSpace::orderBy('desc')->get();
        $vehicleTypes = VehicleType::orderBy('desc')->get();
        $drivers = Driver::orderBy('name')->get();

        return Inertia::render('Dashboard', [
            'stages' => $stages,
            'carriers' => $carriers,
            'parkingSpaces' => $parkingSpaces,
            'vehicleTypes' => $vehicleTypes,
            'drivers' => $drivers
        ]);
    }
}
