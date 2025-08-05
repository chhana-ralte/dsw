<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Allotment;
use App\Models\AllotHostel;
use App\Models\AllotSeat;
use App\Models\CancelSeat;
use App\Models\Clearance;


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
            $allot_seat = false;
        }
        if (!$allot_hostel) {
            return redirect('/allotment/' . $allotment->id)
                ->with(['message' => ['type' => 'warning', 'text' => 'To cancel seat, inmate must be allotted hostel.']]);
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

        if ($allotment->user()) {
            $user = $allotment->user();
            \App\Models\Role_User::where('user_id', $user->id)->delete();
            $user->delete();
            // return $allotment->user()->name;
            // return "User exists";
        }
        $allotment->update([
            // 'valid' => 0,
            'finished' => $request->completed ? '1' : '0',
        ]);
        $allotment->save();

        return redirect('/allotment/' . $allotment->id)
            ->with(['message' => ['type' => 'info', 'text' => 'Seat has been cancelled.']]);
    }

    public function show($cancel_seat_id)
    {
        $cancel_seat = CancelSeat::find($cancel_seat_id);
        $data = [
            'cancel_seat' => $cancel_seat,
        ];
        return view('common.cancelHostel.clearance', $data);
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
        $allotment_id = CancelSeat::find($id)->allotment_id;
        $cancel_seat = CancelSeat::find($id);
        AllotHostel::where('id', $cancel_seat->allot_hostel_id)->update(['valid' => 1]);
        if($cancel_seat->allot_seat_id != 0){
            $allot_seat = AllotSeat::findOrFail($cancel_seat->allot_seat_id);
            if(!AllotSeat::where('seat_id', $allot_seat->seat_id)->where('valid', 1)->exists()){
                AllotSeat::where('id', $cancel_seat->allot_seat_id)->update(['valid' => 1]);
            }
        }

        Allotment::where('id', $cancel_seat->allotment_id)->update(['valid' => 1, 'finished' => 0]);
        Clearance::where('cancel_seat_id', $id)->delete();
        $cancel_seat->delete();
        return redirect('/allotment/' . $allotment_id)
            ->with(['message' => ['type' => 'info', 'text' => 'Seat cancellation undone.']]);
    }

    public function clearance($id)
    {
        $cancel_seat = CancelSeat::findOrFail($id);
        $data = [
            'cancel_seat' => $cancel_seat,
        ];
        return view('common.cancel_seat.clearance', $data);
    }
}
