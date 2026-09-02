<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attmaster;
use App\Models\Att;
use App\Models\Std;
use App\Models\Enroll;
use App\Models\Course;
use App\Models\Attslot;

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
        $course = Course::find($attmaster->course_id);
        $enrolls = Enroll::where('course_id', $course->id)->where('semester', $attmaster->semester)->where('sessn_id', $attmaster->sessn_id);
        $stds = Std::whereIn('id', $enrolls->pluck('std_id'))->orderBy('rollno')->get();

        $data = [
            'attmaster' => $attmaster,
            'stds' => $stds,
            'course' => $course,
        ];
        return view('att.att_take', $data);
        return $attmaster;
    }

    public function store(Attmaster $attmaster)
    {
        if (request()->has('marking')) {
            $attslot = Attslot::create([
                'attmaster_id' => $attmaster->id,
                'dt' => request()->dt,
                'duration' => request()->duration,
            ]);

            foreach (request()->marking as $marking) {
                Att::create([
                    'attslot_id' => $attslot->id,
                    'marking' => 'P',
                    'std_id' => $marking,
                ]);
            }

            return redirect('/att/')
                ->with(['message' => ['type' => 'info', 'text' => 'Successful']]);
        } else {
            return redirect()->back()
                ->with(['message' => ['type' => 'danger', 'text' => 'No attendance selected']])
                ->withInput();
        }



        return request();
    }
}
