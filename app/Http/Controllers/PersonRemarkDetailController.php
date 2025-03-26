<?php

namespace App\Http\Controllers;

use App\Models\PersonRemarkDetail;
use App\Models\PersonRemark;
use Illuminate\Http\Request;

class PersonRemarkDetailController extends Controller
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
    public function create(PersonRemark $personRemark)
    {
        return view('common.person.remark.detail.create',['person_remark' => $personRemark]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,PersonRemark $personRemark)
    {
        PersonRemarkDetail::create([
            'person_remark_id' => $personRemark->id,
            'detail' => $request->detail
        ]);
        return redirect('/person/' . $personRemark->person->id . '/person_remark')->with(['message' => ['type' => 'info', 'text' => 'Remark detail entered successfully']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonRemarkDetail $personRemarkDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonRemarkDetail $personRemarkDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonRemarkDetail $personRemarkDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonRemarkDetail $personRemarkDetail)
    {
        //
    }
}
