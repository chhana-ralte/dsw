<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Allotment;
use App\Models\AllotHostel;
use App\Models\AllotSeat;

class AllotHostelController extends Controller
{
    public function index(Allotment $allotment)
    {
        return "Hostel allotment details";
    }

    public function create(Allotment $allotment)
    {
        if($allotment->cancel_seat()){
            return redirect()->back()->with(['message' => ['type' => 'danger', 'text' => 'Invalid allotment']]);
        }
        else{
            $data = [
                'allotment' => $allotment,
                'allot_hostels' => AllotHostel::where('allotment_id', $allotment->id)->orderBy('valid')->orderBy('id')->get(),
            ];
            return view('common.allot_hostel.create', $data);
        }
    }

    public function store(Request $request, Allotment $allotment)
    {

        if($request->has('hostel')){
            $hostel = \App\Models\Hostel::findOrFail($request->hostel);
        }
        else{
            return redirect()->back()->withErrors(['hostel' => 'Select the hostel'])->withInput();
        }

        if($allotment->valid_allot_hostel()){
            if($allotment->valid_allot_hostel()->hostel->id == $hostel->id){
                return redirect()->back()->withErrors(['hostel' => 'Existing hostel can not be selected'])->withInput();
            }
            $allot_hostel = $allotment->valid_allot_hostel();
            AllotSeat::where('allot_hostel_id', $allot_hostel->id)->update([
                'valid' => 0,
                'to_dt' => date('Y-m-d'),
            ]);
            $allot_hostel->update([
                'valid' => 0,
                'to_dt' => date('Y-m-d'),
            ]);

            $allot_hostel->save();
        }
        AllotHostel::create([
            'allotment_id' => $allotment->id,
            'hostel_id' => $hostel->id,
            'valid' => 1,
            'from_dt' => date('Y-m-d'),
            'to_dt' => $allotment->to_dt
        ]);
        return redirect()->back()
            ->with(['message' => ['type' => 'info', 'text' => 'Hostel changed']]);
    }

    public function show(AllotHostel $allot_hostel)
    {
        if (isset(request()->back_link)) {
            $back_link = request()->back_link;
        } else {
            $back_link = "/hostel/" . $allot_hostel->hostel->id . "/occupants";
        }
        $data = [
            'back_link' => $back_link,
            'allot_hostel' => $allot_hostel
        ];
        return view('common.allot_hostel.show', $data);
    }
}
