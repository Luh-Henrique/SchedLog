<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSpace extends Model
{
    use HasFactory;

    protected $fillable = [
        'desc',
        'local_id',
        'vehicle_types'
    ];

    protected $casts = [
        'vehicle_types' => 'array'
    ];

    public function getRelatedVehicleTypesAttribute()
    {
        return VehicleType::whereIn('id', $this->vehicle_types ?? [])->get();
    }

    public function local(){
        return $this->belongsTo(Local::class, 'local_id', 'id');
    }
}
