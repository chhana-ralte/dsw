<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hostel;
use App\Models\CancelSeat;

class ClearanceController extends Controller
{
    public function index(Hostel $hostel)
    {
        $cancel_seats = CancelSeat::where('hostel_id', $hostel->id)->get();
        $data = [
            'hostel' => $hostel,
            'cancel_seats' => $cancel_seats,
        ];
        return view('clearance.index', $data);
    }
}
