<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DikteiController extends Controller
{
    public function course()
    {

        return view('diktei.course.index');
    }
    public function course_show($course_id)
    {
        $course = \App\Models\Course::findOrFail($course_id);
        return view('diktei.course.show', ['course' => $course]);
    }
    public function index()
    {
        return view('diktei.index');
    }

    public function entry()
    {
        return view('diktei.entry');
    }

    public function option()
    {
        $mzuid = request()->mzuid;
        if (\App\Models\Zirlai::where('mzuid', $mzuid)->exists()) {
            $data = [
                'status' => 'success',
                'zirlai' => \App\Models\Zirlai::where('mzuid', $mzuid)->first(),
            ];
        } else {
            $data = [
                'status' => 'failure',

            ];
        }
        return view('diktei.option', $data);
    }

    public function submit()
    {
        return view('diktei.submit');
    }
}
