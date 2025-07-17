<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        $data = [
            'person' => $person,
            'back_link' => request('back_link')
        ];
        return view('common.person.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Person $person)
    {
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $person->photo = "/storage/" . $path;
        }
        $person->update([
            'name' => request()->name,
            'father' => request()->father,
            'gender' => request()->gender,
            'mobile' => request()->mobile,
            'email' => request()->email,
            'category' => request()->category,
            'state' => request()->state,
            'address' => request()->address,
        ]);

        return redirect(request()->back_link)->with(['message' => ['type' => 'info', 'text' => 'Personal info updated']]);
    }

    public function delete($person_id)
    {
        if (auth()->user()->isAdmin()) {
            $data = [
                'back_link' => request()->back_link,
                'action' => '/person/' . $person_id,
            ];
            return view('confirm_delete', $data);
        } else {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }
    }

    public function destroy(Person $person)
    {
        if (auth()->user()->isAdmin()) {
            $allotments = \App\Models\Allotment::where('person_id', $person->id);
            $user_roles = \App\Models\Role_User::where('type', 'allotment')->whereIn('foreign_id', $allotments->pluck('id'));
            $users = \App\Models\User::whereIn('id', $user_roles->pluck('id'));
            $allot_hostels = \App\Models\AllotHostel::whereIn('allotment_id', $allotments->pluck('id'));
            $allot_seats = \App\Models\AllotSeat::whereIn('allot_hostel_id', $allot_hostels->pluck('id'));
            $students = \App\Models\Student::where('person_id', $person->id);
            $others = \App\Models\Other::where('person_id', $person->id);
            $person_remarks = \App\Models\PersonRemark::where('person_id', $person->id);
            $person_remark_details = \App\Models\PersonRemarkDetail::whereIn('person_remark_id', $person_remarks->pluck('id'));

            $person_remark_details->delete();
            $person_remarks->delete();
            $others->delete();
            $students->delete();
            $allot_seats->delete();
            $allot_hostels->delete();
            $allotments->delete();
            $user_roles->delete();
            $users->delete();
            $person->delete();
            return redirect("/message")->with(['message' => ['type' => 'info', 'text' => 'Personal is deleted']]);
        }
    }
}
