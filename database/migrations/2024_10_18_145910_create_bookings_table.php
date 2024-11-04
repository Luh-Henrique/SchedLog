<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('booking_dt');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles');
            $table->foreignId('carrier_id')->nullable()->constrained('carriers');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('stage_id')->constrained('stages');
            $table->foreignId('parking_space_id')->nullable()->constrained('parking_spaces');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
