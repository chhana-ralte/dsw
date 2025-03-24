<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Other;

class OtherController extends Controller
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
        return view('common.other.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $person_id)
    {
        // return $person_id;
        Other::create([
            'person_id' => $person_id,
            'remark' => $request->remark,
        ]);

        return redirect(request()->back_link)->with(['message' => ['type' => 'info', 'text' => 'Other info updated']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Other $other)
    {
        $data = [
            'other' => $other,
            'back_link' => request()->back_link
        ];
        return view('common.other.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Other $other)
    {
        $other->update([
            'remark' => $request->remark,
        ]);

        return redirect(request()->back_link)->with(['message' => ['type' => 'info', 'text' => 'Other info updated']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
