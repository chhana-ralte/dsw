<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback.index');
    }
    public function create()
    {
        return view('feedback.create');
    }

    public function store()
    {
        return request();
    }
}
