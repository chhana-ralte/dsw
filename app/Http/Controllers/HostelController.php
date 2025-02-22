<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hostel;
use App\Models\Room;
use App\Models\Seat;
use App\Models\AllotSeat;
use App\Models\Allothostel;


class HostelController extends Controller
{
    public function index()
    {
        $hostels = Hostel::orderBy('gender')->orderBy('name')->get();
        return view('common.hostel.index',['hostels' => $hostels]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        $hostel = Hostel::findOrFail($id);
        return view('common.hostel.show',['hostel' => $hostel]);
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

    public function occupants(Hostel $hostel){
        $room_ids = Room::where('hostel_id',$hostel->id)->pluck('id');
        $seat_ids = Seat::whereIn('room_id',$room_ids)->pluck('id');
        $allot_seats = AllotSeat::WhereIn('seat_id',$seat_ids)->where('valid',1)
            ->orderBy('seat_id')
            ->get();
        
        $allot_hostels = AllotHostel::where('hostel_id',$hostel->id)
            ->whereNotIn('id',$allot_seats->pluck('id'))
            ->get();

        $data = [
            'hostel' => $hostel,
            'allot_seats' => $allot_seats,
            'allot_hostels' => $allot_hostels,
        ];
        //return $data;
        return view('common.hostel.occupants',$data);
    }
}
