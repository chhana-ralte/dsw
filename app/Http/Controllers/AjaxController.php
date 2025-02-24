<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                    'valid' => 0
                 
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
}
