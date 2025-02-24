<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AllotHostel;

class AllotHostelController extends Controller
{
    public function show(AllotHostel $allot_hostel){
        return view('common.allot_hostel.show',['allot_hostel' => $allot_hostel]);
    }
}
