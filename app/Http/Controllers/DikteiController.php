<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Zirlai;
use App\Models\Subject;
use App\Models\Diktei;
use App\Models\Course;
use App\Models\Dtallot;

class DikteiController extends Controller
{
    public function course()
    {
        return view('diktei.course.index');
    }
    public function course_show($course_id)
    {
        $course = Course::findOrFail($course_id);
        return view('diktei.course.show', ['course' => $course]);
    }
    public function index()
    {
        return view('diktei.index');
    }

    public function entry()
    {
        if(request()->get('mzuid')){
            $zirlais = Zirlai::where('mzuid', request()->get('mzuid'))->get();
            if(count($zirlais) == 1){
                return redirect('/diktei/option?zirlai_id=' . $zirlais->first()->id . '&mzuid=' . $zirlais->first()->mzuid) ;
            }
            else {
                $data = [
                    'mzuid' => request()->get('mzuid'),
                    'zirlais' => $zirlais,
                ];
            }
        }
        else{
            $data = [
                'mzuid' => '',
                'zirlais' => [],
            ];
        }
        return view('diktei.entry', $data);
    }

    public function option()
    {
        $zirlai = Zirlai::findOrFail(request()->get('zirlai_id'));

        if(count($zirlai->dikteis) > 0){
            $data = [
                'status' => 'submitted',
                'zirlai' => $zirlai,
                'dikteis' => Diktei::where('zirlai_id', $zirlai->id)->orderBy('serial')->get(),
            ];
        }
        else{
            $data = [
                'status' => 'success',
                'zirlai' => $zirlai,
            ];
        }

        return view('diktei.option', $data);
    }

    public function submit()
    {
        // return request()->all();

        foreach(request()->subject as $key => $val){
            Diktei::updateOrCreate([
                'zirlai_id' => request()->zirlai_id,
                'serial' => $key+1,
            ],[
                'zirlai_id' => request()->zirlai_id,
                'serial' => $key+1,
                'subject_id' => $val,
            ]);
        }
        return redirect('/diktei/option?zirlai_id=' . request()->zirlai_id);
    }

    public function subject_allotments(){
        $subjects = Subject::select('subjects.*')->join('courses', 'courses.id', 'subjects.course_id')
            ->where('courses.cbcs', 1)->get();
        // return $subjects;
        if(request()->get('subject_id')){
            $dtallots = Dtallot::where('subject_id', request()->get('subject_id'))->orderBy('zirlai_id')->get();
            $subject = Subject::find(request()->get('subject_id'));
        }
        else{
            $subject = false;
            $dtallots = [];
        }
        $data = [
            'subject' => $subject,
            'dtallots' => $dtallots,
            'subjects' => $subjects,
        ];
        return view('diktei.dtallot', $data);
    }
    public function allot_subjects(){
        $zirlais = Zirlai::select('zirlais.*')->join('dikteis', 'dikteis.zirlai_id', 'zirlais.id')->where('dikteis.serial', 1)->orderBy('created_at')->get();
        Dtallot::truncate();
        foreach($zirlais as $zl){
            foreach(Diktei::where('zirlai_id', $zl->id)->orderBy('serial')->get() as $dt){
                $subject = Subject::where('id', $dt->subject_id)->first();
                if($subject->capacity > Diktei::where('subject_id', $subject->id)->count()){
                    Dtallot::create([
                        'zirlai_id' => $zl->id,
                        'subject_id' => $subject->id,
                        'type' => 'IMJ',
                    ]);
                    break;
                }
            }
        }
        return redirect('/diktei/dtallot')->with(['message' => ['type' => 'info', 'text' => "Successful"]]);
    }

    public function clear_options(){
        $zirlai = Zirlai::findOrFail(request()->post('zirlai_id'));

        Diktei::where('zirlai_id', $zirlai->id)->delete();
        Dtallot::where('zirlai_id', $zirlai->id)->delete();
        return redirect()->back()->with(['message' => ['type' => 'info', 'text' => "Cleared"]]);
    }
}
