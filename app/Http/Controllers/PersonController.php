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
        return view('common.person.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Person $person)
    {
        $person->update([
            'name' => request()->name,
            'father' => request()->father,
            'mobile' => request()->mobile,
            'email' => request()->email,
            'category' => request()->category,
            'state' => request()->state,
            'address' => request()->address,
        ]);

        return redirect(request()->back_link)->with(['message' => ['type' => 'info', 'text' => 'Personal info updated']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        //
    }
}
