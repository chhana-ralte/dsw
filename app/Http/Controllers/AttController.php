<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $attslots = Attslot::where('attmaster_id', $attmaster->id)->orderBy('dt')->get();

        $enrolls = Enroll::where('course_id', $attmaster->course_id)->where('semester', $attmaster->semester)->where('sessn_id', $attmaster->sessn_id);
        $stds = Std::whereIn('id', $enrolls->pluck('std_id'))->orderBy('rollno')->get();
        $atts = Att::whereIn('attslot_id', $attslots->pluck('id'))->get();

        $arr  = [];
        foreach ($atts as $att) {
            $arr[$att->std_id][$att->attslot_id] = 'P';
        }

        $data = [
            'attslots' => $attslots,
            'stds' => $stds,
            'atts' => $arr,
            'attmaster' => $attmaster
        ];
        return view('att.att_show', $data);
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
        if (request()->has('stds')) {
            $attslot = Attslot::updateOrCreate([
                'attmaster_id' => $attmaster->id,
                'dt' => request()->dt,
                'duration' => request()->duration,
            ], [
                'attmaster_id' => $attmaster->id,
                'dt' => request()->dt,
                'duration' => request()->duration,
            ]);

            Att::where('attslot_id', $attslot->id)
                ->whereNotIn('std_id', request()->stds)
                ->delete();

            foreach (request()->stds as $std) {
                Att::updateOrCreate(
                    [
                        'attslot_id' => $attslot->id,
                        'marking' => 'P',
                        'std_id' => $std,
                    ],
                    [
                        'attslot_id' => $attslot->id,
                        'marking' => 'P',
                        'std_id' => $std,
                    ]
                );
            }

            return redirect('/att/')
                ->with(['message' => ['type' => 'info', 'text' => 'Successful']]);
        } else {
            return redirect()->back()
                ->with(['message' => ['type' => 'danger', 'text' => 'No attendance selected']])
                ->withInput();
        }
    }
}
