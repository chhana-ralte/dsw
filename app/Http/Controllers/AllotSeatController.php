<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AllotSeatController extends Controller
{
    public function allotSeat($allot_hostel_id){
        $allot_hostel = \App\Models\AllotHostel::findOrFail($allot_hostel_id);
        $rooms = \App\Models\Room::where('hostel_id',$allot_hostel->hostel_id)->orderBy('roomno')->get();
        $data = [
            'allot_hostel' => $allot_hostel,
            'rooms' => $rooms
        ];
        return view('common.allot_seat.allotSeat',$data);
    }
}
