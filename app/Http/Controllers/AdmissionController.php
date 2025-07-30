<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Admission;
use App\Models\Sessn;
use App\Models\Hostel;
use App\Models\Allotment;
use App\Models\AllotHostel;
use App\Models\AllotSeat;

use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Allotment $allotment)
    {
        $admissions = DB::select("SELECT AD.*
                FROM admissions AD JOIN sessns SS ON SS.id=AD.sessn_id
                WHERE allotment_id = " . $allotment->id . "
                ORDER BY SS.start_yr, SS.odd_even
            ");

        if(request()->has('back_link')){
            $back_link = request()->back_link;
        }
        else{
            $back_link = "/allotment/" . $allotment->id;
        }
        $data = [
            'allotment' => $allotment,
            'admissions' => \App\Models\Admission::hydrate($admissions),
            'back_link' => $back_link,
        ];
        // return $data;
        return view('common.admission.allotment-index', $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Allotment $allotment)
    {
        if (!(auth()->user() && auth()->user()->can('manage', $allotment))) {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }

        if (count($allotment->allot_hostels) > 0) {
            $data = [
                'allotment' => $allotment,
                'sessns' => \App\Models\Sessn::orderBy('start_yr')->orderBy('odd_even')->get(),
                'sessn' => \App\Models\Sessn::current(),
            ];

            return view('common.admission.create-existing', $data);
        }
        else { // new admission
            if (isset($_GET['sessn_id'])) {
                $sessn = Sessn::findOrFail($_GET['sessn_id']);
            } else {
                $sessn = Sessn::default();
            }
            $data = [
                'admissions' => Admission::where('allotment_id', $allotment->id)->get(),
                'allotment' => $allotment,
                'sessn' => $sessn
            ];
            return view('common.admission.create', $data);
        }
    }
    /*
        Form for storing
    */
    public function store(Request $request, Allotment $allotment)
    {
        if (!(auth()->user() && auth()->user()->can('manage', $allotment))) {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }

        if($request->has('admitted')){
            $errors = [];
            if(!is_numeric($request->amount)){
                //array_push($errors, ['amount' => "It should be number"]);
                $errors['amount'] = "It should be number";
            }
            if($request->dt == ''){
                //array_push($errors, ['dt' => "Date can not be empty"]);
                $errors['dt'] = "Date can not be empty";
            }
            // return $errors;
            if(count($errors) > 0){
                return redirect()->back()->withErrors($errors)->withInput();
            }
        }

        if (request()->type && request()->type == 'new') {

            $allot_hostel = AllotHostel::updateOrCreate(
                [
                    'allotment_id' => $allotment->id,
                    'hostel_id' => $allotment->hostel->id,
                    'valid' => 1,
                ],
                [
                    'allotment_id' => $allotment->id,
                    'hostel_id' => $allotment->hostel->id,
                    'valid' => 1,
                    'from_dt' => $allotment->from_dt,
                    'to_dt' => $allotment->to_dt,
                ]
            );

            AllotSeat::where('seat_id', request()->seat)->where('valid', 1)->update(['valid' => 0]);

            $allot_seat = AllotSeat::updateOrCreate(
                [
                    'allot_hostel_id' => $allot_hostel->id,
                    'seat_id' => request()->seat,
                ],
                [
                    'allot_hostel_id' => $allot_hostel->id,
                    'seat_id' => request()->seat,
                    'valid' => 1,
                    'from_dt' => $allot_hostel->from_dt,
                    'to_dt' => $allot_hostel->to_dt,
                ]
            );

            if (request()->admitted) {
                Admission::updateOrCreate(
                    [
                        'allotment_id' => $allotment->id,
                        'sessn_id' => request()->sessn,
                        'allot_hostel_id' => $allot_hostel->id,
                    ],
                    [
                        'allotment_id' => $allotment->id,
                        'sessn_id' => request()->sessn,
                        'allot_hostel_id' => $allot_hostel->id,
                        'amount' => $request->amount,
                        'payment_dt' => $request->dt,
                    ]
                );

                $allotment->update([
                    'admitted' => 1,
                    'confirmed' => 1,
                    'valid' => 1,
                ]);
            }
            return redirect('/hostel/' . $allotment->hostel->id . '/admission?adm_type=new')
                ->with(['message' => ['type' => 'info', 'text' => 'Seat allotted.']]);
        } else { // Existing allotments
            request()->validate([
                'amount' => 'numeric:required',
                'payment_dt' => 'required',
                'sessn' => 'required',
            ]);

            if ($allotment->valid_allot_hostel()) {
                $allot_hostel_id = $allotment->valid_allot_hostel()->id;
            } else {
                $allot_hostel_id = 0;
            }
            Admission::updateOrCreate(
                [
                    'sessn_id' => request()->sessn,
                    'allotment_id' => $allotment->id,
                ],
                [
                    'sessn_id' => request()->sessn,
                    'allotment_id' => $allotment->id,
                    'payment_dt' => request()->payment_dt,
                    'amount' => request()->amount,
                    'allot_hostel_id' => $allot_hostel_id,
                ]
            );

            $allotment->update(['confirmed' => 1]);
            $allotment->save();
        }
        if($allotment->start_sessn_id == \App\Models\Sessn::current()->id)
        {
            $adm_type = 'new';
        }
        else{
            $adm_type = 'old';
        }
        return redirect('/hostel/' . $allotment->hostel->id . '/admission?adm_type=' . $adm_type)
            ->with(['message' => ['type' => 'info', 'text' => 'Admission detail created.']]);
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
        if (!(auth()->user() && auth()->user()->can('manage', $admission->allotment))) {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }
        if(request()->has('back_link')){
            $back_link = request()->back_link;
        }
        else{
            $back_link = "/allotment/" . $admission->allotment;
        }
        $data = [
            'allotment' => $admission->allotment,
            'admission' => $admission,
            'sessns' => \App\Models\Sessn::orderBy('start_yr')->orderBy('odd_even')->get(),
            'back_link' => $back_link
        ];
        return view('common.admission.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Admission $admission)
    {
        if (!(auth()->user() && auth()->user()->can('manage', $admission->allotment))) {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }
        request()->validate([
            'amount' => 'numeric:required',
            'payment_dt' => 'required',
            'sessn' => 'required',

        ]);

        $admission->update(
            [
                'sessn_id' => request()->sessn,
                'payment_dt' => request()->payment_dt,
                'amount' => request()->amount,
            ]
        );
        return redirect('/allotment/' . $admission->allotment->id . '/admission?back_link=' . request()->back_link)
            ->with(['message' => ['type' => 'info', 'text' => 'Admission details updated.']]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admission $admission)
    {
        $admission->delete();
        return "Deleted";
    }

    public function admission_decline($allotment_id)
    {
        $allotment = Allotment::findOrFail($allotment_id);
        $allotment->update([
            'valid' => 0,
        ]);
        return redirect('/hostel/' . $allotment->hostel->id . '/admission?sessn=1&adm_type=new')
            ->with(['message' => ['type' => 'info', 'text' => 'Admission declined and made invalid']]);
    }
}
