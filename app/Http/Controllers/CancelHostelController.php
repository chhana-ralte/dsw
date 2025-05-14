<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hostel;
use App\Models\CancelSeat;

class CancelHostelController extends Controller
{
    public function index(Hostel $hostel){
        $allot_hostels = \App\Models\AllotHostel::where('hostel_id',$hostel->id);
        $cancel_seats = CancelSeat::whereIn('allot_hostel_id',$allot_hostels->pluck('id'))->get();
        $data = [
            'hostel' => $hostel,
            'cancel_seats' => $cancel_seats,
        ];
        // return $data;
        return view('common.cancelHostel.index',$data);
    }
}
