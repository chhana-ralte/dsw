<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attmaster;
use App\Models\Att;
use App\Models\Std;
use App\Models\Enroll;

class AttController extends Controller
{
    public function index()
    {
        return view('att.index');
    }

    public function show(Attmaster $attmaster)
    {
        return $attmaster;
    }

    public function take(Attmaster $attmaster)
    {
        return $attmaster;
    }
}
