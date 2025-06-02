<?php

namespace App\Http\Controllers;

use App\Models\Allotment;
use App\Models\Requirement;
use Illuminate\Http\Request;

class RequirementController extends Controller
{

    public function index(Allotment $allotment)
    {
        $data = [
            'allotment' => $allotment,
            'requirements' => Requirement::where('allotment_id', $allotment->id)->get(),
        ];
        return view('requirement.index', $data);
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
