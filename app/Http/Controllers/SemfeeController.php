<?php

namespace App\Http\Controllers;

use App\Models\Semfee;
use Illuminate\Http\Request;

class SemfeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(isset(request()->hostel_id))
        {
            $hostel = \App\Models\Hostel::find(request()->hostel_id);
            if($hostel){
                return $hostel->valid_allot_hostels();
            }
        }
        return request()->hostel_id;;
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
    public function show(Semfee $semfee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Semfee $semfee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Semfee $semfee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semfee $semfee)
    {
        //
    }
}
