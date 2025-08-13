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
            $zirlai = \App\Models\Zirlai::where('mzuid', $mzuid)->first();
            if(count($zirlai->dikteis) > 0){
                $data = [
                    'status' => 'submitted',
                    'zirlai' => $zirlai,
                    'dikteis' => \App\Models\Diktei::where('zirlai_id', $zirlai->id)->orderBy('serial')->get(),
                ];
            }
            else{
                $data = [
                    'status' => 'success',
                    'zirlai' => $zirlai,
                ];
            }

        } else {
            $data = [
                'status' => 'failure',

            ];
        }
        return view('diktei.option', $data);
    }

    public function submit()
    {
        // return request()->all();

        foreach(request()->subject as $key => $val){
            \App\Models\Diktei::updateOrCreate([
                'zirlai_id' => request()->zirlai_id,
                'serial' => $key+1,
            ],[
                'zirlai_id' => request()->zirlai_id,
                'serial' => $key+1,
                'subject_id' => $val,
            ]);
        }
        //return view('diktei.submit');
    }
}
