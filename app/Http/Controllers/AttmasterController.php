<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttmasterController extends Controller
{
    public function index(){

        return view('att.index');
    }

    public function create(){
        $courses = \App\Models\Course::OrderBy('department_id')->orderBy('name')->get();
        $sessns = \App\Models\Sessn::orderBy('start_yr')->orderBy('odd_even')->get();
        $data = [
            'courses' => $courses,
            'sessns' => $sessns,
        ];
        return view('att.attmaster_create', $data);
    }

    public function store(Request $request){
        return $request;
    }
}
