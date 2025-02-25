<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    public $guarded = [];

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function allot_seat(){
        return AllotSeat::where('seat_id',$this->id)->where('valid',1)->first();
    }

    public function active_allot_seats(){
        return AllotSeat::where('seat_id',$this->id)->where('valid',1)->get();
    }


    public function remarks(){
        return $this->hasMany(SeatRemark::class);
    }

    //public function

    public function exOccupants(){

    }
}
