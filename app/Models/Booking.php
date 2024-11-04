<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'vehicle_id',
        'carrier_id',
        'user_id',
        'stage_id',
        'parking_space_id'
    ];
}
