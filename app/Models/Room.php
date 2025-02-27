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

    public function ex_allot_seats(){
        $seat_ids = Seat::where('room_id',$this->id)->pluck('id');

        $ex_allot_seats = AllotSeat::whereIn('seat_id',$seat_ids)
            ->where('valid',0)
            ->orderBy('leave_dt')
            ->get();
        return $ex_allot_seats;
    }
}
