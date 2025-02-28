<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Hostel;
use App\Models\Seat;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Hostel $hostel)
    {
        //return $hostel;
        $rooms = Room::where('hostel_id',$hostel->id)->orderBy('roomno')->get();
        $data = [
            'hostel' => $hostel,
            'rooms' => $rooms
        ];
        return view('common.room.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Hostel $hostel)
    {
        return view('common.room.create',['hostel' => $hostel]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Hostel $hostel, Request $request)
    {

        if(Room::where('hostel_id',$hostel->id)->where('roomno',$request->roomno)->exists()){
            return redirect("/hostel/$hostel->id/room/create")->with(['message' => ['type' => 'danger', 'text' => 'Room number already exists']])->withInput();
        }

        if(!is_numeric($request->capacity)){
            return redirect("/hostel/$hostel->id/room/create")->with(['message' => ['type' => 'danger', 'text' => 'Capacity should be numeric value']])->withInput();
        }

        //return $request->available;
        $room = Room::create([
            'roomno' => $request->roomno,
            'hostel_id' => $hostel->id,
            'capacity' => $request->capacity,
            'available' => $request->capacity,
            'type' => $request->capacity == 1? 'Single' : ($request->capacity == 2? 'Double' : ($request->capacity == 3? 'Triple':'Dorm'))
        ]);

        if($request->remark){
            RoomRemark::create([
                'room_id' => $room->id,
                'remark' => $request->remark,
                'remark_dt' => date('Y-m-d')
            ]);
        }

        for($i=0; $i<$room->capacity; $i++){
            Seat::create([
                'room_id' => $room->id,
                'available' => 1,
                'serial' => $i+1
            ]);
        }

        return redirect("/room/$room->id")->with(['message' => ['type' => 'info', 'text' => 'New room created']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $seats = Seat::where('room_id',$id)->orderBy('serial')->get();
        $data = [
            'room' => Room::findOrFail($id),
            'seats' => $seats
        ];
        return view('common.room.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $seats = Seat::where('room_id',$id)->orderBy('serial')->get();
        $data = [
            'room' => Room::findOrFail($id),
            'seats' => $seats
        ];
        return view('common.room.edit',$data);
    }
    
    public function update(Request $request, string $id)
    {
        return redirect("/room/$id")->with(['message' => ['type' => 'info','text' => "Updated successfully"]]);
    }

    public function destroy(string $room_id)
    {

    }

    public function remark($id){
        $room = Room::findOrFail($id);
        return view('common.room.remark',['room' => $room]);
    }

    public function remarkStore($id){
        \App\Models\RoomRemark::create([
            'room_id' => $id,
            'remark_dt' => date('Y-m-d'),
            'remark' => request()->remark
        ]);
        return $id;
    }
}
