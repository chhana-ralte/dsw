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
        $data = [
            'allotment' => $allotment,
            'allot_hostels' => AllotHostel::where('allotment_id', $allotment->id)->orderBy('valid')->orderBy('id')->get(),
        ];
        return view('common.allot_hostel.create', $data);
        // return "Hostel allotment details";
    }

    public function store(Request $request, Allotment $allotment)
    {
        // return $allotment;
        $allot_hostels = AllotHostel::where('allotment_id', $allotment->id);
        $allot_seats = AllotSeat::whereIn('allot_hostel_id', $allot_hostels->pluck('id'));

        $allot_seats->where('valid', 1)->update([
            'valid' => 0,
            'to_dt' => date('Y-m-d'),
        ]);

        $allot_hostels->where('valid', 1)->update([
            'valid' => 0,
            'to_dt' => date('Y-m-d'),
            'leave_dt' => date('Y-m-d'),
        ]);

        AllotHostel::create([
            'allotment_id' => $allotment->id,
            'hostel_id' => $request->hostel,
            'valid' => 1,
            'from_dt' => date('Y-m-d'),
            'to_dt' => $allotment->to_dt
        ]);
        return redirect('/allotment/' . $allotment->id)
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
