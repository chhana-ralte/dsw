<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    public $guarded = [];

    public static function default()
    {
        return Hostel::make(['id' => 0, 'name' => 'NoHostel']);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // seats hostel->rooms-seats
    public function seats()
    {
        return $this->hasManyThrough(Seat::class, Room::class);
    }

    public function capacity()
    {
        return Room::where('hostel_id', $this->id)->sum('capacity');
    }

    public function available()
    {
        return Room::where('hostel_id', $this->id)->sum('available');
    }

    public function filled()
    {
        $room_ids = Room::where('hostel_id', $this->id)->pluck('id');
        $seat_ids = Seat::whereIn('room_id', $room_ids)->pluck('id');
        return AllotSeat::whereIn('seat_id', $seat_ids)->where('valid', 1)->count();
        //return Room::where('hostel_id',$this->id)->sum('available');
    }

    public function remarks()
    {
        return $this->hasMany(HostelRemark::class);
    }

    public function vacant()
    {
        return $this->available() - $this->filled();
    }

    public function wardens()
    {
        return $this->hasMany(Hostel::class);
    }

    public function warden()
    {
        return Warden::where('hostel_id', $this->id)->where('valid', 1)->first();
    }

    public function valid_warden()
    {
        return Warden::where('hostel_id', $this->id)->where('valid', 1)->first();
    }

    public function valid_allot_hostels()
    {
        return AllotHostel::where('hostel_id', $this->id)->where('valid', 1)->get();
    }
}
