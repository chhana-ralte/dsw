<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdmUpdateController extends Controller
{
    public function index(){
        return view('adm_bulk_update.index');
    }
}
