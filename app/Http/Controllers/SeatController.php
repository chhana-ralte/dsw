<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AllotSeat;
use App\Models\Seat;
use App\Models\Hostel;
use App\Models\Room;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Room $room)
    {
        $seats = Seat::where('room_id',$room->id)->orderBy('serial')->get();
        $data = [
            'seats' => $seats,
            'room' => $room
        ];
        return view('common.seat.index',$data);
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
    public function show(string $id)
    {
        $seat = Seat::find($id);
        return view('common.seat.show',['seat' => $seat]);
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

    public function allotSeat($seat_id){
        $seat = Seat::findOrFail($seat_id);

        $data = [
            'seat' => $seat
        ];
        return view('common.seat.allotSeat',$data);
    }

    public function allotSeatStore($seat_id){
        AllotSeat::where('seat_id',$seat_id)->where('valid',1)->update([
            'valid' => 0,
            'leave_dt' => date('Y-m-d'),
            'to_dt' => date('Y-m-d')
        ]);
        //return "Partial";
        AllotSeat::create([
            'allot_hostel_id' => request()->allot_hostel_id,
            'seat_id' => $seat_id,
            'from_dt' => date('Y-m-d'),
            'to_dt' => date('Y-m-d'),
            'valid' => 1
        ]);
        return "Success";
    }
}
