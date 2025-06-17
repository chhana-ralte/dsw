<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function current_occupants() // All occupants, empty rooms are not shown
    {
        // DB::table('allot_hostels')->join('allot_seats', 'allot_hostels.id', '=', 'allot_seats.allot_hostel_id')
        //     ->join('seats', 'allot_seats.seat_id', '=', 'seats.id')
        //     ->join('rooms', 'seats.room_id', '=', 'rooms.id')
        //     ->where('allot_hostels.hostel_id', $this->id)
        //     ->where('allot_seats.valid', 1)
        //     ->select('allot_hostels.*', 'allot_seats.*', 'seats.*', 'rooms.*')
        //     ->get();

        $occupants = DB::select('SELECT R.id as room_id,R.roomno, R.type as roomtype, S.id as seat_id, S.serial, P.name, P.father, P.mobile, P.email, P.state, P.address, P.photo, P.gender, ST.id as student_id, ST.course, ST.department, ST.mzuid, ST.rollno, AH.id as allot_hostel_id, A.id as allotment_id, AST.id as allot_seat_id
            FROM (people P LEFT JOIN students ST ON P.id=ST.person_id) JOIN allotments A on P.id=A.person_id
            JOIN allot_hostels AH ON AH.allotment_id=A.id AND AH.valid = 1
            JOIN hostels H ON H.id = AH.hostel_id
            LEFT JOIN (allot_seats AST JOIN (seats S JOIN rooms R on R.id=S.room_id) ON S.id=AST.seat_id) ON AST.allot_hostel_id = AH.id AND AST.valid = 1
            WHERE H.id = :id
            ORDER BY R.roomno,S.serial;', ['id' => $this->id]);
        return Occupant::hydrate($occupants);
    }

    public function room_occupants()
    { // all rooms and their occupants. Empty rooms also will be shown
        $occupants = DB::select('SELECT R.id as room_id,R.roomno, R.type as roomtype, S.id as seat_id, S.serial, S.available, P.id as person_id, P.name, P.father, P.mobile, P.email, P.state, P.address, P.photo, P.gender, ST.id as student_id, ST.course, ST.department, ST.mzuid, ST.rollno, AH.id as allot_hostel_id, A.id as allotment_id, AST.id as allot_seat_id
            FROM (rooms R JOIN hostels H ON H.id=R.hostel_id) JOIN seats S ON R.id=S.room_id
            LEFT JOIN (allot_seats AST JOIN allot_hostels AH ON AH.id=AST.allot_hostel_id AND AH.valid = 1 JOIN allotments A ON A.id=AH.allotment_id JOIN (people P LEFT JOIN students ST ON P.id=ST.person_id) ON P.id=A.person_id) ON AST.seat_id = S.id AND AST.valid = 1
            WHERE H.id = :hostel_id
            ORDER BY R.roomno,S.serial;', ['hostel_id' => $this->id]);
        return Occupant::hydrate($occupants);
    }

    public function unallotted()
    {
        $occupants = DB::select('SELECT P.id as person_id, P.name, P.father, P.mobile, P.email, P.state, P.address, P.photo, P.gender, ST.id as student_id, ST.course, ST.department, ST.mzuid, ST.rollno, AH.id as allot_hostel_id, A.id as allotment_id
            FROM (people P left JOIN students ST ON P.id=ST.person_id) JOIN allotments A ON P.id=A.person_id
            JOIN (allot_hostels AH JOIN hostels H ON H.id=AH.hostel_id) ON A.id = AH.allotment_id AND AH.valid = 1
            WHERE AH.id NOT IN (SELECT allot_hostel_id FROM allot_seats WHERE valid = 1)
            AND H.id = :hostel_id ORDER BY P.name;', ['hostel_id' => $this->id]);
        return Occupant::hydrate($occupants);
    }
}
