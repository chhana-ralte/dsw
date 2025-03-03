<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Hostel;
use App\Models\Room;
use App\Models\Seat;
use App\Models\AllotSeat;
use App\Models\AllotHostel;


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
        $rooms = Room::where('hostel_id',$hostel->id)->get();
        $seats = Seat::whereIn('room_id',$rooms->pluck('id'))->get();
        $allotted_seats = AllotSeat::whereIn('seat_id',$seats->pluck('id'))->get();
        $unallotted_seats = AllotHostel::where('hostel_id',$hostel->id)->whereNotIn('id',$allotted_seats->pluck('allot_hostel_id'))->get();
        
        $data = [
            'hostel' => $hostel,
            'rooms' => $rooms,
            'seats' => $seats,
            'allotted_seats' => $allotted_seats,
            'unallotted_seats' => $unallotted_seats
        ];
        return view('common.hostel.show',$data);
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
            ->whereNotIn('id',$allot_seats->pluck('allot_hostel_id'))
            ->get();
        
        if(isset($_GET['allot_seats']) && $_GET['allot_seats'] == 1){
            $data = [
                'hostel' => $hostel,
                'allot_seats' => $allot_seats,
                'allot_hostels' => false
            ];
    
        }
        else{
            $data = [
                'hostel' => $hostel,
                'allot_hostels' => $allot_hostels,
                'allot_seats' => false
            ];
        }
        //return $data;
        return view('common.hostel.occupants',$data);
    }
}
