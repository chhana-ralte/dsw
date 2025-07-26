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

    public function get_all_seats($type = 'object'){
        $seats = DB::select("SELECT S.*
                FROM rooms R join seats S ON R.id = S.room_id AND S.available = 1
                WHERE R.hostel_id = '". $this->id ."'
                ORDER BY R.capacity, R.roomno, S.serial ");

        if($type == 'array'){
            $tmp = array();
            $seats = Seat::Hydrate($seats);
            foreach($seats as $s){
                $x = [
                    'id' => $s->id,
                    'serial' => $s->serial,
                    'available' => $s->available,
                    'room_id' => $s->room_id,
                    'roomno' => $s->room->roomno,
                    'room_capacity' => $s->room->capacity,
                    'room_type' => $s->room->capacity == 1?'Single':($s->room->capacity == 2?"Double":($s->room->capacity == 3?"Triple":"Dorm")),
                    'hostel_id' => $s->room->hostel->id,
                ];
                array_push($tmp, $x);
            }
            return $tmp;
            return (object)$tmp;
            return Seat::Hydrate($tmp);
        }
        else{
            return Seat::Hydrate($seats);
        }

    }

    public function get_available_seats($type = 'object'){

        // $room_ids = \App\Models\Room::where('hostel_id', $this->id)->pluck('id');
        // $seat_ids = \App\Models\Seat::whereIn('room_id', $room_ids)->pluck('id');

        // $occupied_seat_ids = \App\Models\AllotSeat::whereIn('seat_id', $seat_ids)->where('valid', 1)->pluck('seat_id');

        // $available_seat_ids = \App\Models\Seat::where('available', '<>', 0)->whereIn('room_id', $room_ids)->whereNotIn('id', $occupied_seat_ids)->pluck('id');

        // $seats = DB::table('seats')->join('rooms', 'seats.room_id', 'rooms.id')
        //     ->select('seats.id', 'rooms.roomno', 'rooms.id as room_id', 'seats.serial')
        //     ->whereIn('seats.id', $available_seat_ids)
        //     ->get();

        // return $seats;











        $seats = DB::select("SELECT S.*
                FROM rooms R join seats S ON R.id = S.room_id AND S.available = 1
                WHERE S.id NOT IN (SELECT seat_id FROM allot_seats WHERE valid = 1)
                AND R.hostel_id = '". $this->id ."'
                ORDER BY R.capacity, R.roomno, S.serial ");
        if($type == 'array'){
            $tmp = array();
            $seats = Seat::Hydrate($seats);
            foreach($seats as $s){
                $x = [
                    'id' => $s->id,
                    'serial' => $s->serial,
                    'available' => $s->available,
                    'room_id' => $s->room_id,
                    'roomno' => $s->room->roomno,
                    'room_capacity' => $s->room->capacity,
                    'room_type' => $s->room->capacity == 1?'Single':($s->room->capacity == 2?"Double":($s->room->capacity == 3?"Triple":"Dorm")),
                    'hostel_id' => $s->room->hostel->id,
                ];
                array_push($tmp, $x);
            }
            return $tmp;
            return (object)$tmp;
            return Seat::Hydrate($tmp);
        }
        else{
            return Seat::Hydrate($seats);
        }

    }
}
