<?php

namespace App\Http\Controllers;

use App\Models\Allotment;
use App\Models\Requirement;
use Illuminate\Http\Request;

class RequirementController extends Controller
{

    public function index(Allotment $allotment)
    {
        if($allotment->valid_allot_hostel() && $allotment->valid_allot_hostel()->valid_allot_seat()){
            $data = [
                'allotment' => $allotment,
                'allot_hostel' => $allotment->valid_allot_hostel(),
                'allot_seat' => $allotment->valid_allot_hostel()->valid_allot_seat(),
                'requirements' => Requirement::where('allot_hostel_id', $allotment->valid_allot_hostel()->id)->get(),
            ];
            return view('requirement.index', $data);
        }
        else{
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Allotment $allotment)
    {
        if($allotment->valid_allot_hostel() && $allotment->valid_allot_hostel()->valid_allot_seat()){
            $data = [
                'allotment' => $allotment,
                'allot_hostel' => $allotment->valid_allot_hostel(),
                'allot_seat' => $allotment->valid_allot_hostel()->valid_allot_seat(),
                'requirements' => Requirement::where('allot_hostel_id', $allotment->valid_allot_hostel()->id)->get(),
            ];
            return view('requirement.create', $data);
        }
        else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Allotment $allotment)
    {
        if($allotment->valid_allot_hostel() && $allotment->valid_allot_hostel()->valid_allot_seat()){
            $request->validate([
                'hostel' => 'required'
            ]);

            $requirement = Requirement::updateOrCreate([
                'person_id' => $allotment->person->id,
                'for_sessn_id' => \App\Models\Sessn::current()->next()->id,
            ],
            [
                'person_id' => $allotment->person->id,
                'allot_hostel_id' => $allotment->valid_allot_hostel()->id,
                'hostel_id' => $request->hostel,
                'roomcapacity' => $request->roomcapacity,
                'type' => 'Next Session',
                'for_sessn_id' => \App\Models\Sessn::current()->next()->id,
                'dt' => now(),
                'user_id' => auth()->user()->id,
            ]);

            return redirect("/allotment/" . $allotment->id . "/requirement")->with(['message' => ['type' => 'info', 'text' => 'Requirement submitted']]);
        }
        else{
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Requirement $requirement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requirement $requirement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Requirement $requirement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requirement $requirement)
    {
        //
    }
}
