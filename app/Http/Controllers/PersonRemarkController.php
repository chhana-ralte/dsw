<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\PersonRemark;
use App\Models\PersonRemarkDetail;
use Illuminate\Http\Request;

class PersonRemarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Person $person)
    {
        if(isset($request->back_link)){
            $back_link = $request->back_link;
        }
        else{
            $allot_hostel = $person->valid_allotment()->valid_allot_hostel();
            $back_link = '/allot_hostel/' . $allot_hostel->id;
        }
        $data = [
            'person' => $person,
            'person_remarks' => PersonRemark::where('person_id',$person->id)->orderBy('remark_dt')->get(),
            'back_link' => $back_link
        ];
        return view('common.person.remark.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Person $person)
    {
        return view('common.person.remark.create',['person' => $person]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Person $person)
    {
        $remark = PersonRemark::create([
            'person_id' => $person->id,
            'remark_dt' => $request->remark_dt,
            'remark' => $request->remark,
            'score' => $request->score
        ]);
        return redirect('/person/' . $person->id . '/person_remark')->with(['message' => ['type' => 'info', 'text' => 'Remark entered successfully']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonRemark $personRemark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonRemark $personRemark)
    {
        return view('common.person.remark.edit',['person_remark' => $personRemark]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonRemark $personRemark)
    {
        $personRemark->update([
            'person_id' => $personRemark->person->id,
            'remark_dt' => $request->remark_dt,
            'remark' => $request->remark,
            'score' => $request->score
        ]);
        return redirect('/person/' . $personRemark->person->id . '/person_remark')->with(['message' => ['type' => 'info', 'text' => 'Remark updated']]);    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonRemark $personRemark)
    {
        // return $personRemark->id;
        $person = $personRemark->person;
        PersonRemarkDetail::where('person_remark_id',$personRemark->id)->delete();
        $personRemark->delete();
        return redirect('/person/' . $person->id . '/person_remark')->with(['message' => ['type' => 'info', 'text' => 'Remark deleted successfully']]);
    }
}
