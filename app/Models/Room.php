<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $guarded = [];
    public function hostel(){
        return $this->belongsTo(Hostel::class);
    }

    public function seats(){
        return $this->hasMany(Seat::class);
    }

    public function remarks(){
        return $this->hasMany(RoomRemark::class);
    }

    public function filled(){
        $seat_ids = Seat::where('room_id',$this->id)->pluck('id');
        $allot_seat_ids = AllotSeat::whereIn('seat_id',$seat_ids)->where('valid',1)->pluck('seat_id');
        return Seat::whereIn('id',$allot_seat_ids)->get();
        //return Seat::where('room_id',$this->id)->with('allot_seats',function())->get();
    }

    public function valid_allot_seats(){
        return AllotSeat::whereIn('seat_id',$this->seats->pluck('id'))->where('valid',1)->get();
    }

    public function invalid_allot_seats(){
        return AllotSeat::whereIn('seat_id',$this->seats->pluck('id'))->where('valid',0)->get();
    }
}
