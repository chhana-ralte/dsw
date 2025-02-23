<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    public $guarded = [];
    
    public function rooms(){
        return $this->hasMany(Room::class);
    }

    public function capacity(){
        return Room::where('hostel_id',$this->id)->sum('capacity');
    }

    public function available(){
        return Room::where('hostel_id',$this->id)->sum('available');
    }

    public function filled(){
        $room_ids = Room::where('hostel_id',$this->id)->pluck('id');
        $seat_ids = Seat::whereIn('room_id',$room_ids)->pluck('id');
        return AllotSeat::whereIn('seat_id',$seat_ids)->where('valid',1)->count();
        //return Room::where('hostel_id',$this->id)->sum('available');
    }

    public function vacant(){
        return $this->available() - $this->filled();
    }
}
