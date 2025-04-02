<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Person;
use App\Models\Allotment;


class AdmissionCheckController extends Controller
{
    public function check(){
        if(isset(request()->allotment)){
            $allotment = Allotment::findOrFail(request()->allotment);
            if($allotment->person->student()){
                $student = $allotment->person->student();
                $data = [
                    'allotment' => $allotment,
                    'student' => $student
                ];
            }
            else{
                $data = [
                    'allotment' => $allotment,
                    'student' => ''
                ];
            }
            
            return view('admissioncheck.check',$data);
        }
        else{
            return view('admissioncheck.check');
        }
    }

    public function checkStore(){
        if(request()->mzuid == ""){
            $mzuid = "98s7t9eut9sreujhtguisdhg";
        }
        else{
            $mzuid = request()->mzuid;
        }
        if(request()->rollno == ""){
            $rollno = "98s7t9eut9sreujhtguisdhg";
        }
        else{
            $rollno = request()->rollno;
        }
        $students = Student::where('mzuid',$mzuid)->orWhere('rollno',$rollno);
        if(count($students->get()) == 1){
            $person = $students->first()->person;
            $allotment = $person->valid_allotment();
            return redirect('/admissioncheck?allotment=' . $allotment->id . '&rand=' . uniqid());
        }
        else if(count($students->get()) == 0){
            return redirect('/admissioncheck')
                ->with(['message' => ['type' => 'danger', 'text' => 'Information not found']])
                ->withInput();
        }
        else{
            // return "asdadsa";
            $persons = Person::whereIn('id',$students->pluck('person_id'));
            $allotments = Allotment::whereIn('person_id',$persons->pluck('id'));
            $data = [
                'allotments' => $allotments->get(),
            ];
            return view('admissioncheck.multiple',$data);
        }
    }
}
