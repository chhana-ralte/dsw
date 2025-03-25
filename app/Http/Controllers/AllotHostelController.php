<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AllotHostel;

class AllotHostelController extends Controller
{
    public function show(AllotHostel $allot_hostel){
        if(isset(request()->back_link)){
            $back_link = request()->back_link;
            
        }
        else{
            $back_link = "/hostel/" . $allot_hostel->hostel->id . "/occupants";
        }
        $data = [
            'back_link' => $back_link,
            'allot_hostel' => $allot_hostel
        ];
        return view('common.allot_hostel.show',$data);
    }
}
