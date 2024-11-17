<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::group(['prefix' => 'booking', 'as' => 'booking.'], function () {
        Route::post('store', [BookingController::class, 'store'])->name('store');

        Route::post('getBookings', [BookingController::class, 'getBookings'])->name('getBookings');
        Route::get('{booking}/nextStage', [BookingController::class, 'nextStage'])->name('nextStage')->where('booking', '[0-9]+');
        Route::get('{booking}/previousStage', [BookingController::class, 'previousStage'])->name('previousStage')->where('booking', '[0-9]+');
        Route::get('{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel')->where('booking', '[0-9]+');
    });

    Route::group(['prefix' => 'carrier', 'as' => 'carrier.'], function () {
        Route::get('', [CarrierController::class, 'index'])->name('index');

        Route::post('', [CarrierController::class, 'store'])->name('store');
        Route::delete('{carrier?}', [CarrierController::class, 'destroy'])->name('destroy')->where('destroy', '[0-9]+');
    });
});
