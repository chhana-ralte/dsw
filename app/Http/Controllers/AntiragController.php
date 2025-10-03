<?php

namespace App\Http\Controllers;

use App\Models\Antirag;
use Illuminate\Http\Request;

class AntiragController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('antirag.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('.antirag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Antirag::updateOrCreate([
            'user_id' => auth()->user()->id,
            'allotment_id' => auth()->user()->allotment()->id
        ], [
            'user_id' => auth()->user()->id,
            'allotment_id' => auth()->user()->allotment()->id,
            'link' => $request->link,
        ]);
        return redirect('/antirag')
            ->with(['message' => ['type' => 'success', 'text' => 'You have successfully updated the undertaking status.']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Antirag $antirag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Antirag $antirag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Antirag $antirag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Antirag $antirag)
    {
        //
    }
}
