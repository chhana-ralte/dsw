<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Std;
use App\Models\Enroll;
use App\Models\Sessn;

class EnrollController extends Controller
{
    public function index(Course $course, Sessn $sessn, $semester = 0)
    {
        $enrolls = Enroll::where('course_id', $course->id)
            ->where('sessn_id', $sessn->id);
        if ($semester != 0) {
            $enrolls = $enrolls->where('semester', $semester);
        }
        $enrolls = $enrolls->get();

        $sql = "SELECT DISTINCT semester FROM enrolls WHERE course_id=" . $course->id . " AND sessn_id = " . $sessn->id . " ORDER BY semester";
        $semesters = DB::select($sql);
        $data = [
            'enrolls' => $enrolls,
            'course' => $course,
            'sessn' => $sessn,
            'semester' => $semester,
            'semesters' => $semesters
        ];
        return view('att.enroll_index', $data);
    }

    public function tmp_store(Course $course, Sessn $sessn, $semester = 0)
    {
        // return $semester;
        $course = Course::find(request()->course_id);
        $sessn = Sessn::find(request()->sessn_id);
        $semester = $semester;
        if (Std::where('rollno', request()->rollno)->exists()) {
            $std = Std::where('rollno', request()->rollno)->first();
        } else {
            $std = [
                'id' => 0,
                'rollno' => request()->rollno,
                'name' => '',
                'phone' => '',
                'email' => '',
                'semester' => '0',
            ];
            $std = (object) $std;
        }
        $data = [
            'course' => $course,
            'sessn' => $sessn,
            'semester' => $semester,
            'std' => $std
        ];
        // return $data;
        return view('att.enroll_create', $data);
    }

    public function store(Course $course, Sessn $sessn, $semester = 0)
    {
        $std = Std::updateOrCreate(
            [
                'rollno' => request()->rollno
            ],
            [
                'rollno' => request()->rollno,
                'name' => request()->name,
                'phone' => request()->phone,
                'email' => request()->email,
                'course_id' => $course->id,
            ]
        );

        $enroll = Enroll::updateOrCreate(
            [
                'std_id' => $std->id,
                'course_id' => $course->id,
                'sessn_id' => $sessn->id,
                'semester' => request()->semester,
            ],
            [
                'std_id' => $std->id,
                'course_id' => $course->id,
                'sessn_id' => $sessn->id,
                'semester' => request()->semester,
            ]
        );

        return redirect('/att/course/' . $course->id . '/sessn/' . $sessn->id . '/enroll/' . request()->semester)
            ->with(['message' => ['type' => 'info', 'text' => 'Enrolled successfully']]);
    }
}
