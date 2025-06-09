<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Hostel;
use App\Models\Room;
use App\Models\Seat;
use App\Models\AllotSeat;
use App\Models\AllotHostel;
use App\Models\Allotment;
use App\Models\CancelSeat;


class HostelController extends Controller
{
    public function index()
    {
        $hostels = Hostel::orderBy('gender')->orderBy('name')->get();
        return view('common.hostel.index', ['hostels' => $hostels]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Hostel $hostel)
    {
        // return view('test.casttest', ['occupants' => $hostel->current_occupants()]);

        if (!auth()->user() || !auth()->user()->can('view', $hostel)) {
            abort(403);
        }
        $rooms = Room::where('hostel_id', $hostel->id);
        $seats = Seat::whereIn('room_id', $rooms->pluck('id'));
        $allot_hostels = AllotHostel::where('hostel_id', $hostel->id);
        $no_seats = $seats->count();
        $allotted_seats = AllotSeat::where('valid', 1)->whereIn('seat_id', $seats->pluck('id'));
        $no_available_seats = $seats->where('available', '<>', 0)->count();
        $no_allotted_seats = AllotSeat::where('valid', 1)->whereIn('seat_id', $seats->pluck('id'))->count();
        $no_vacant_seats = $no_available_seats - $no_allotted_seats;
        $no_unallotted = AllotHostel::where('hostel_id', $hostel->id)->where('valid', 1)->whereNotIn('id', $allotted_seats->pluck('allot_hostel_id'))->count();
        $no_new_allotted = Allotment::where('valid', 1)->where('admitted', 0)->where('hostel_id', $hostel->id)->whereNotIn('id', $allot_hostels->pluck('allotment_id'))->count();
        $no_seat_cancelled = CancelSeat::whereIn('allot_hostel_id', $allot_hostels->pluck('id'))->count();
        $sessn = \App\Models\Sessn::default();
        $data = [
            'hostel' => $hostel,
            'no_seats' => $no_seats,
            'no_available_seats' => $no_available_seats,
            'no_allotted_seats' => $no_allotted_seats,
            'no_vacant_seats' => $no_vacant_seats,
            'no_rooms' => $rooms->count(),
            'no_unallotted' => $no_unallotted,
            'no_new_allotted' => $no_new_allotted,
            'no_seat_cancelled' => $no_seat_cancelled,
            'sessn' => $sessn,
        ];

        // return $data;
        return view('common.hostel.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function occupants(Hostel $hostel)
    {
        // return $hostel->room_occupants();
        if (isset($_GET['allot_seats']) && $_GET['allot_seats'] == 0) {
            $data = [
                'hostel' => $hostel,
                'occupants' => $hostel->unallotted(),
                'seats' => false
            ];
        } else {
            $data = [
                'hostel' => $hostel,
                'seats' => true,
                'occupants' => $hostel->room_occupants(),
            ];
            return view('common.hostel.occupants2', $data);
        }

        $rooms = $hostel->rooms();

        $seats = Seat::whereIn('room_id', $rooms->pluck('id'));

        // $seat_ids = Seat::whereIn('room_id', $room_ids)->pluck('id');
        $allot_seats = AllotSeat::WhereIn('seat_id', $seats->pluck('id'))->where('valid', 1);
        //     ->orderBy('seat_id')

        $allot_hostels = AllotHostel::where('hostel_id', $hostel->id)
            ->where('valid', 1)
            ->whereNotIn('id', $allot_seats->pluck('allot_hostel_id'))
            ->get();

        if (isset($_GET['allot_seats']) && $_GET['allot_seats'] == 0) {
            $data = [
                'hostel' => $hostel,
                'allot_hostels' => $allot_hostels,
                'allot_seats' => false
            ];
        } else {
            $data = [
                'hostel' => $hostel,
                'seats' => $seats->get(),
                'allot_hostels' => false
            ];
        }
        //return $data;
        return view('common.hostel.occupants', $data);
    }
}
