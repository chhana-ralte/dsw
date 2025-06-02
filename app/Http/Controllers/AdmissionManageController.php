<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdmissionManageController extends Controller
{
    public function index()
    {
        $admissions = \App\Models\Admission::where('valid', 1)->get();
        $data = [
            'admissions' => $admissions,

        ];
        return view('admission_manage.index', $data);
    }
}
