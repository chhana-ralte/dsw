<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Sessn;
use App\Models\Hostel;
use App\Models\Allotment;
use App\Models\AllotHostel;

use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Hostel $hostel)
    {
        // return $hostel;
        if(isset($_GET['sessn'])){
            $sessn = Sessn::findOrFail($_GET['sessn']);
        }
        else{
            $sessn = Sessn::current();
        }
        
        $adm_type = isset($_GET['adm_type']) && $_GET['adm_type'] == 'new'?'new':'old';

        $allot_hostels = AllotHostel::where('hostel_id',$hostel->id)->where('valid',1);
        
        if($adm_type == 'old'){
            
            $data = [
                'sessn' => $sessn,
                'allot_hostels' => $allot_hostels->get(),
                'hostel' => $hostel,
                'adm_type' => $adm_type
            ];
            return view("common.admission.index",$data);
        }
        else{
            $new_allotments = Allotment::where('hostel_id',$hostel->id)->whereNotIn('id',$allot_hostels->pluck('allotment_id'));
            $data = [
                'sessn' => $sessn,
                'new_allotments' => $new_allotments->get(),
                'hostel' => $hostel,
                'adm_type' => $adm_type
            ];
            // return $data;
            return view("common.admission.newadmissionindex",$data);
        }
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
    public function show(Admission $admission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admission $admission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admission $admission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admission $admission)
    {
        //
    }
}
