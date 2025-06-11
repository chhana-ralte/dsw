<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $guarded = [];
    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function remarks()
    {
        return $this->hasMany(RoomRemark::class);
    }

    public function filled()
    {
        $seat_ids = Seat::where('room_id', $this->id)->pluck('id');
        $allot_seat_ids = AllotSeat::whereIn('seat_id', $seat_ids)->where('valid', 1)->pluck('seat_id');
        return Seat::whereIn('id', $allot_seat_ids)->get();
        //return Seat::where('room_id',$this->id)->with('allot_seats',function())->get();
    }

    public function valid_allot_seats()
    {
        return AllotSeat::whereIn('seat_id', $this->seats->pluck('id'))->where('valid', 1)->get();
    }

    public function invalid_allot_seats()
    {
        return AllotSeat::whereIn('seat_id', $this->seats->pluck('id'))->where('valid', 0)->get();
    }

    public function occupants()
    {
        $occupants = DB::select('SELECT R.id as room_id,r.roomno, r.type as roomtype, S.id as seat_id, S.serial, S.available, P.name, P.father, P.mobile, P.email, P.state, P.address, P.photo, P.gender, ST.id as student_id, ST.course, ST.department, ST.mzuid, ST.rollno, AH.id as allot_hostel_id, A.id as allotment_id, AST.id as allot_seat_id
            FROM (rooms R JOIN hostels H ON H.id=R.hostel_id) JOIN seats S ON R.id=S.room_id
            LEFT JOIN (allot_seats AST JOIN allot_hostels AH ON AH.id=AST.allot_hostel_id AND AH.valid = 1 JOIN allotments A ON A.id=AH.allotment_id JOIN (people P LEFT JOIN students ST ON P.id=ST.person_id) ON P.id=A.person_id) ON AST.seat_id = S.id AND AST.valid = 1
            WHERE R.id = :room_id
            ORDER BY S.serial;', ['room_id' => $this->id]);
        return Occupant::hydrate($occupants);
    }

    public function type()
    {
        return $this->capacity == 1 ? 'Single' : ($this->capacity == 2 ? 'Double' : ($this->capacity == 3 ? 'Triple' : ($this->capacity > 3 ? 'Dorm' : 'Undefined')));
    }
}
