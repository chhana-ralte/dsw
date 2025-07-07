<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Person;
use App\Models\Application;

class MergeController extends Controller
{
    public function index()
    {
        return view('merge.index');
    }

    public function find()
    {
        if (request()->has('mzuid')) {
            $students = Student::where('mzuid', request()->mzuid);
            if ($students->count() > 1) {
                $data = [
                    'students' => $students->get(),
                ];
                return view('merge.multiple_students', $data);
            } else if ($students->count() == 1) {
                $student = $students->first();
                $applications = Application::where('mzuid', $student->mzuid);
                if ($applications->count() > 1) {
                    $data = [
                        'applications' => $applications->get(),
                    ];
                    return view('merge.multiple_applications', $data);
                } else if ($applications->count() == 1) {
                    $data = [
                        'student' => $student,
                        'application' => $applications->first(),
                    ];
                    return view('merge.duplicate_application', $data);
                } else {
                    return "Nil";
                }
            } else {
                return "Nil";
            }
        }
        return redirect()->back()->with(['message' => ['type' => 'danger', 'text' => 'Person not found']]);
        return request()->all();
    }

    public function update(Request $request)
    {
        return $request;
        $student = Student::where('mzuid', $request->mzuid)->first();
        $person = $student->person;
        $application = Application::where('mzuid', $request->mzuid)->first();

        if ($student) {
            $student->name = $request->name;
            $student->father = $request->father;
            $student->mobile = $request->mobile;
            $student->email = $request->email;
            $student->dob = $request->dob;
            $student->gender = $request->gender;
            $student->address = $request->address;
            $student->rollno = $request->rollno;
            $student->department = $request->department;
            $student->course = $request->course;
            $student->mzuid = $request->mzuid;
            $student->save();
        }
    }
}
