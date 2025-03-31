<?php

namespace App\Http\Controllers;

use App\Models\Allotment;
use App\Models\Notification;
use Illuminate\Http\Request;

class AllotmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Notification $notification)
    {
        $data = [
            'notification' => $notification
        ];
        return view('common.allotment.create', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Notification $notification)
    {
        $data = [
            'notification' => $notification
        ];
        return view('common.allotment.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Notification $notification)
    {
        // return $request->from_dt;
        $request->validate([
            'name' => 'required',
            'hostel' => ['numeric','min:1']
        ]);

        $person = Person::create([
            'name' => $request->name,
            'father' => $request->father,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'category' => $request->category,
            'state' => $request->state,
            'address' => $request->address,
        ]);

        if($request->selected == 'student'){
            $student = Student::create([
                'rollno' => $request->rollno,
                'course' => $request->course,
                'department' => $request->department,
                'mzuid' => $request->mzuid,
                'person_id' => $person->id
            ]);
        }

        if($request->selected == 'other'){
            $other = Other::create([
                'remark' => $request->remark,
                'person_id' => $person->id
            ]);
        }

        $allotment = Allotment::create([
            'person_id' => $person->id,
            'hostel_id' => $request->hostel,
            'notification_id' => $notification->id,
            'from_dt' => $request->from_dt,
            'to_dt' => $request->to_dt,
            'admitted' => 0,
            'valid' => 1,
            'finished' => 0,
            'from_dt' => 12
        ]);

        return redirect('/allotment/' . $allotment->id)->with(['message' => ['type' => 'info', 'text' => 'Allotment details entered successfully']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Allotment $allotment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Allotment $allotment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Allotment $allotment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Allotment $allotment)
    {
        //
    }
}
