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


    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function carrier(){
        return $this->belongsTo(Carrier::class, 'carrier_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stage(){
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    public function parkingSpace(){
        return $this->belongsTo(ParkingSpace::class, 'parking_space_id');
    }

    public function getNextStage(){
        return Stage::where('position', ($this->stage->position_id + 1))->where('flow_id', $this->stage->flow_id)->first();
    }

    public function getPreviousStage(){
        return Stage::where('position', ($this->stage->position_id - 1))->where('flow_id', $this->stage->flow_id)->first();
    }

    public function getCancelStage(){
        return Stage::where('code', Stage::CANCELED)->where('flow_id', $this->stage->flow_id)->first();
    }

}
