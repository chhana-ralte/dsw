<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Person;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Person $person)
    {
        $data = [
            'person' => $person,
            'back_link' => request('back_link')
        ];
        return view('common.student.create',$data);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $person_id)
    {
        Student::create([
            'person_id' => $person_id,
            'rollno' => $request->rollno,
            'course' => $request->course,
            'department' => $request->department,
            'mzuid' => $request->mzuid,
        ]);

        return redirect(request()->back_link)->with(['message' => ['type' => 'info', 'text' => 'Student info updated']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $data = [
            'student' => $student,
            'back_link' => request()->back_link
        ];
        return view('common.student.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $student->update([
            'rollno' => $request->rollno,
            'course' => $request->course,
            'department' => $request->department,
            'mzuid' => $request->mzuid,
        ]);
        return redirect(request()->back_link)->with(['message' => ['type' => 'info', 'text' => 'Student info updated']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
