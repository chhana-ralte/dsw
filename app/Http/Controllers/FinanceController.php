<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(){
        return view('finance.index');
        if (isset(request()->hostel_id)) {
            $allot_hostel = \App\Models\AllotHostel::find(3);
            $hostel = \App\Models\Hostel::find(request()->hostel_id);
            if(isset(request()->sessn_id)){
                $sessn = Sessn::find($sessn_id);
            }
            else{
                $sessn = \App\Models\Sessn::current();
            }
            if ($hostel) {
                $data = [
                    'sessn' => $sessn,
                    'hostel' => $hostel,
                    'allot_hostels' => $hostel->valid_allot_hostels()
                ];
                return view('finance.index', $data);

            }
            else{
                return view('finance.index-none');
            }
        }
        else{
            return view('finance.index-none');
        }
        return view('finance.index');
    }
}
