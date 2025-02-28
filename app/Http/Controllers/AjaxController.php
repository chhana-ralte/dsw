<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function getSeats($room_id){
        $seats = \App\Models\Seat::where('room_id',$room_id)->orderBy('serial')->get();
        return $seats;
    }

    public function allotSeatStore(){
        //return date('Y-m-d');
        $current_seat = \App\Models\AllotSeat::where('allot_hostel_id',request()->allot_hostel_id)
            ->where('valid',1)->first();
        if($current_seat)
        {
            if($current_seat->seat_id == request()->seat_id){
                return "Done";
            }
            else{
                $current_seat->update([
                    'valid' => 0,
                    'leave_dt' => date('Y-m-d'),
                    'to_dt' => date('Y-m-d')
                ]);
            }
        }
        
        \App\Models\AllotSeat::create([
            'allot_hostel_id' => request()->allot_hostel_id,
            'seat_id' => request()->seat_id,
            'from_dt' => date('Y-m-d'),
            'to_dt' => date('Y-m-d'),
            'valid' => 1
        ]);
    
        return "Success";
    }

    public function deallocateSeat($seat_id){
        //return $seat_id;
        \App\Models\AllotSeat::where('seat_id',$seat_id)->where('valid',1)->update([
            'valid' => 0,
            'leave_dt' => date('Y-m-d'),
            'to_dt' => date('Y-m-d')
        ]);
        return "Success";
    }

    public function getAllotHostels($hostel_id){
        $search = $_GET['search'];
        $data = DB::table('people')->join('allot_hostels','people.id','=','allot_hostels.person_id')
            ->select('allot_hostels.id','people.name','people.address')
            ->where('allot_hostels.hostel_id',$hostel_id)
            ->whereLike('name','%' . $search . '%')
            ->get();
            
        //$data = \App\Models\Person::whereLike('name','%' . $search . '%')->get();
        return $data;
    }

    //public function
}
