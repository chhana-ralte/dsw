<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Allotment;
use App\Models\AllotHostel;
use App\Models\AllotSeat;
use App\Models\CancelSeat;


class CancelSeatController extends Controller
{
    public function index(Allotment $allotment)
    {
        return $allotment;
    }

    public function create(Allotment $allotment)
    {
        if ($allotment->valid_allot_hostel()) {
            $allot_hostel = $allotment->valid_allot_hostel();
            if ($allotment->valid_allot_hostel()->valid_allot_seat()) {
                $allot_seat = $allotment->valid_allot_hostel()->valid_allot_seat();
            } else {
                if ($allotment->valid_allot_hostel()->allot_seats->count() > 0) {
                    $allot_seat = $allotment->valid_allot_hostel()->allot_seat();
                } else {
                    $allot_seat = false;
                }
            }
        } else {
            $allot_hostel = false;
        }
        $data = [
            'allotment' => $allotment,
            'allot_hostel' => $allot_hostel,
            'allot_seat' => $allot_seat,
        ];
        // return $data;
        return view('common.cancel_seat.create', $data);
        return $allotment;
    }

    public function store(Request $request, Allotment $allotment)
    {
        // return auth()->user();
        $cancelSeat = CancelSeat::updateOrCreate(
            [
                'allotment_id' => $allotment->id,
            ],
            [
                'allotment_id' => $allotment->id,
                'allot_hostel_id' => $request->allot_hostel_id,
                'allot_seat_id' => $request->allot_seat_id,
                'user_id' => auth()->user()->id,
                'finished' => $request->completed ? '1' : '0',
                'cleared' => $request->cleared ? '1' : '0',
                'outstanding' => $request->cleared ? '0' : $request->outstanding,
                'issue_dt' => $request->issue_dt,
                'leave_dt' => $request->leave_dt,
                'remark' => $request->remark,
            ]
        );

        $allot_hostels = AllotHostel::where('allotment_id', $allotment->id);

        $allot_seats = AllotSeat::whereIn('allot_hostel_id', $allot_hostels->pluck('id'));

        $allot_seats->update(['valid' => 0]);

        $allot_hostels->update(['valid' => 0]);

        return redirect('/allotment/' . $allotment->id)
            ->with(['message' => ['type' => 'info', 'text' => 'Seat has been cancelled.']]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
