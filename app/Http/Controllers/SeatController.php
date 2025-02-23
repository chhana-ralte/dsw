<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        //
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
}
