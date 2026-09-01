<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attmaster;

class AttmasterController extends Controller
{
    public function index()
    {
        $attmasters = Attmaster::where('user_id', auth()->user()->id)->where('active', 1)->get();
        return view('att.index', ['attmasters' => $attmasters]);
    }

    public function create()
    {
        $courses = \App\Models\Course::OrderBy('department_id')->orderBy('name')->get();
        $sessns = \App\Models\Sessn::orderBy('start_yr')->orderBy('odd_even')->get();
        $data = [
            'courses' => $courses,
            'sessns' => $sessns,
        ];
        return view('att.attmaster_create', $data);
    }

    public function store(Request $request)
    {
        $attmaster = Attmaster::create([
            'subject_code' => $request->subject_code,
            'subject_name' => $request->subject_name,
            'course_id' => $request->course_id,
            'sessn_id' => $request->sessn_id,
            'semester' => $request->semester,
            'user_id' => auth()->user()->id
        ]);
        return redirect('/att')->with(['message' => ['type' => 'info', 'text' => 'Created Successfully']]);
    }

    public function show(Attmaster $attmaster)
    {

        return view('att.attmaster_show', ['attmaster' => $attmaster]);
    }
}
