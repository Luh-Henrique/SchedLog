<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSpace extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'desc',
        'local_id',
        'vehicle_types'
    ];

    protected $casts = [
        'vehicle_types' => 'array'
    ]
}
