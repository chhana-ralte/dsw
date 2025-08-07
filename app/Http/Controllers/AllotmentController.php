<?php

namespace App\Http\Controllers;

use App\Models\Allotment;
use App\Models\Person;
use App\Models\Hostel;
use App\Models\Student;
use App\Models\Other;
use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AllotmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Notification $notification)
    {
        $data = [
            'notification' => $notification,
            'allotments' => Allotment::where('notification_id', $notification->id)->orderBy('hostel_id')->orderBy('sl')->paginate()
        ];
        return view('common.allotment.index', $data);
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
        // return $request;
        // return $request->from_dt;
        $request->validate([
            'name' => 'required',
            'hostel' => ['numeric', 'min:1']
        ]);

        $person = Person::create([
            'name' => $request->name,
            'father' => $request->father,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'category' => $request->category,
            'state' => $request->state,
            'address' => $request->address,
        ]);

        if ($request->selected == 'student') {
            $student = Student::create([
                'rollno' => $request->rollno,
                'course' => $request->course,
                'department' => $request->department,
                'mzuid' => $request->mzuid,
                'person_id' => $person->id
            ]);
        }

        if ($request->selected == 'other') {
            $other = Other::create([
                'remark' => $request->remark,
                'person_id' => $person->id
            ]);
        }

        $allotment = Allotment::create([
            'person_id' => $person->id,
            'hostel_id' => $request->hostel,
            'notification_id' => $notification->id,
            'roomtype' => $request->roomtype,
            'from_dt' => $request->from_dt,
            'to_dt' => $request->to_dt,
            'start_sessn_id' => $request->start_sessn,
            'end_sessn_id' => $request->end_sessn,
            'admitted' => 0,
            'confirmed' => 0,
            'valid' => 1,
            'finished' => 0,
            'rand' => \App\Models\Lib::rand(2),
        ]);

        return redirect('/allotment/' . $allotment->id)->with(['message' => ['type' => 'info', 'text' => 'Allotment details entered successfully']]);
    }

    public function show(Allotment $allotment)
    {
        if (auth()->user() && auth()->user()->cannot('view', $allotment)) {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }

        if ($allotment->valid_allot_hostel()) {
            $current_hostel = $allotment->valid_allot_hostel()->hostel;
        } else if ($allotment->hostel) {
            $current_hostel = $allotment->hostel;
        } else {
            $current_hostel = Hostel::default();
        }
        $data = [
            'allotment' => $allotment,
            'current_hostel' => $current_hostel,
            'back_link' => request()->has('back_link') ? request()->back_link : '/notification/' . $allotment->notification->id . '/allotment',
        ];
        // return $data;
        return view('common.allotment.show', $data);
    }

    public function edit(Allotment $allotment)
    {
        if (auth()->user() && auth()->user()->cannot('manage_self', $allotment)) {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }
        $data = [
            'back_link' => request()->back_link,
            'allotment' => $allotment,
        ];
        return view('common.allotment.edit', $data);
    }

    public function update(Request $request, Allotment $allotment)
    {
        if (auth()->user() && auth()->user()->can('manage', $allotment)) {
            $allotment->update([
                'start_sessn_id' => $request->start_sessn,
                'end_sessn_id' => $request->end_sessn,
                'roomtype' => $request->roomtype,
                'from_dt' => $request->from_dt,
                'to_dt' => $request->to_dt,
                'hostel_id' => $request->hostel,
                'valid' => $request->valid ? '1' : 0,
                'finished' => $request->finished ? '1' : 0
            ]);
        } else if (auth()->user() && auth()->user()->can('manage_self', $allotment)) {
            $allotment->update([
                'start_sessn_id' => $request->start_sessn,
                'end_sessn_id' => $request->end_sessn,
            ]);
        }
        return redirect($request->back_link)->with(['message' => ['type' => 'info', 'text' => 'Allotment updated']]);
    }

    public function destroy(Allotment $allotment)
    {
        //
    }

    public function clear_allotment(Allotment $allotment)
    {
        if (auth()->user()->isAdmin()) {
            $allot_hostels = \App\Models\AllotHostel::where('allotment_id', $allotment->id);
            $allot_seats = \App\Models\AllotSeat::whereIn('allot_hostel_id', $allot_hostels->pluck('id'));

            $allot_seats->delete();
            $allot_hostels->delete();
            $allotment->update([
                'admitted' => 0,
                'valid' => 1,
                'finished' => 0,
            ]);
            return redirect("/allotment/" . $allotment->id)->with(['message' => ['type' => 'info', 'text' => 'Allotment detail cleared']]);
        }
    }
}
