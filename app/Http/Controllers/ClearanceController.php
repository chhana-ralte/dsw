<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Hostel;
use App\Models\CancelSeat;
use App\Models\Clearance;

class ClearanceController extends Controller
{
    public function index(Hostel $hostel)
    {
        $allot_hostels = \App\Models\AllotHostel::where('hostel_id', $hostel->id)->where('valid', 0);
        $cancel_seats = CancelSeat::whereIn('allot_hostel_id', $allot_hostels->pluck('id'))->get();
        $data = [
            'hostel' => $hostel,
            'cancel_seats' => $cancel_seats,
        ];
        return view('common.clearance.index', $data);
    }

    public function create(CancelSeat $cancelSeat)
    {
        $data = [
            'cancel_seat' => $cancelSeat,
        ];
        return view('common.clearance.create', $data);
    }

    public function store(Request $request, CancelSeat $cancelSeat)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rollno' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'hostel' => 'required|string|max:255',
            'roomno' => 'required|string|max:255',
            'leave_dt' => 'required|string|max:255',
            'issue_dt' => 'required|string|max:255',
            'warden' => 'required|string|max:255',
        ]);

        $clearance = $cancelSeat->clearance()->updateOrCreate(
            [
                'cancel_seat_id' => $cancelSeat->id,
            ],
            [
                'allotment_id' => $cancelSeat->allotment_id,
                'cancel_seat_id' => $cancelSeat->id,
                'name' => $request->name,
                'rollno' => $request->rollno,
                'course' => $request->course,
                'department' => $request->department,
                'hostel' => $request->hostel,
                'roomno' => $request->roomno,
                'leave_dt' => $request->leave_dt,
                'issue_dt' => $request->issue_dt,
                'warden' => $request->warden,
            ]
        );

        return redirect('/clearance/' . $clearance->id . '/view?allotment_id=' . $clearance->allotment_id)->with(['message' => ['type' => 'info', 'text' => 'Clearance created successfully!']]);
    }

    public function show($clearance_id)
    {
        $clearance = Clearance::findOrFail($clearance_id);

        if (isset(request()->allotment_id) && $clearance->allotment_id == request()->allotment_id) {
            $data = [
                'clearance' => $clearance,
            ];
            return view('common.clearance.show', $data);
        } else {
            // return "asds";
            abort(403);
        }
    }

    public function download($clearance_id)
    {
        $clearance = Clearance::findOrFail($clearance_id);
        $data = [
            'clearance' => $clearance,
        ];
        $pdf = Pdf::loadView('common.clearance.clearance', $data);

        // return $pdf->download();
        // return $pdf->stream();

        return $pdf->download($clearance->name . '.pdf');
    }

    public function search()
    {
        if (request()->has('allotment_id') && request()->has('clearance_id')) {
            $clearance = Clearance::where('allotment_id', request()->allotment_id)
                ->where('id', request()->clearance_id)
                ->first();
            $data = [
                'clearance' => $clearance,
                'search' => true
            ];
            return view('common.clearance.search', $data);
        } else {
            return view('common.clearance.search');
        }
    }
}
