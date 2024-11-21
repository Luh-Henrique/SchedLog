<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\ParkingSpaceController;
use App\Http\Controllers\VehicleTypeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::group(['prefix' => 'booking', 'as' => 'booking.'], function () {
        Route::post('store', [BookingController::class, 'store'])->name('store');

        Route::get('getBookings', [BookingController::class, 'getBookings'])->name('getBookings');
        Route::get('{booking}/nextStage', [BookingController::class, 'nextStage'])->name('nextStage')->where('booking', '[0-9]+');
        Route::get('{booking}/previousStage', [BookingController::class, 'previousStage'])->name('previousStage')->where('booking', '[0-9]+');
        Route::get('{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel')->where('booking', '[0-9]+');
    });

    Route::group(['prefix' => 'carrier', 'as' => 'carrier.'], function () {
        Route::get('', [CarrierController::class, 'index'])->name('index');

        Route::post('', [CarrierController::class, 'store'])->name('store');
        Route::delete('{carrier?}', [CarrierController::class, 'destroy'])->name('destroy')->where('carrier', '[0-9]+');
    });

    Route::group(['prefix' => 'vehicleType', 'as' => 'vehicleType.'], function () {
        Route::get('', [VehicleTypeController::class, 'index'])->name('index');

        Route::post('', [VehicleTypeController::class, 'store'])->name('store');
        Route::delete('{vehicleType?}', [VehicleTypeController::class, 'destroy'])->name('destroy')->where('vehicleType', '[0-9]+');
    });

    Route::group(['prefix' => 'parkingSpace', 'as' => 'parkingSpace.'], function () {
        Route::get('', [ParkingSpaceController::class, 'index'])->name('index');

        Route::post('', [ParkingSpaceController::class, 'store'])->name('store');
        Route::delete('{parkingSpace?}', [ParkingSpaceController::class, 'destroy'])->name('destroy')->where('parkingSpace', '[0-9]+');
    });

    Route::group(['prefix' => 'local', 'as' => 'local.'], function () {
        Route::get('', [LocalController::class, 'index'])->name('index');

        Route::post('', [LocalController::class, 'store'])->name('store');
        Route::delete('{local?}', [LocalController::class, 'destroy'])->name('destroy')->where('local', '[0-9]+');
    });

    Route::group(['prefix' => 'driver', 'as' => 'driver.'], function () {
        Route::get('', [DriverController::class, 'index'])->name('index');

        Route::post('', [DriverController::class, 'store'])->name('store');
        Route::delete('{driver?}', [DriverController::class, 'destroy'])->name('destroy')->where('driver', '[0-9]+');
    });
});
