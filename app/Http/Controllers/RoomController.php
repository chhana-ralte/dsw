<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomRemark;
use App\Models\Hostel;
use App\Models\Seat;
use App\Models\AllotSeat;

class RoomController extends Controller
{

    public function index(Hostel $hostel)
    {
        //return $hostel;
        $rooms = Room::where('hostel_id',$hostel->id)->orderBy('roomno');
        $seats = Seat::whereIn('room_id',$rooms->pluck('id'));
        $allot_seats = AllotSeat::whereIn('seat_id',$seats->pluck('id'))->where('valid',1);
        // return "Hello";
        $allotted_seats = Seat::whereIn('id',$allot_seats->pluck('seat_id'));
        // return "Hello";
        $vacant_seats = $seats->whereNotIn('id',$allotted_seats->pluck('id'));

        if(isset($_GET['status']) && $_GET['status'] == 'vacant'){
            $vacant_seats = $seats->whereNotIn('id',$allotted_seats->pluck('id'));
            $data = [
                'hostel' => $hostel->get(),
                'rooms' => $rooms->get(),
                'vacant_seats' => $vacant_seats->get(),
                'status' => 'vacant'
            ];
        }

        else if(isset($_GET['status']) && $_GET['status'] == "non-available"){
            $non_room = Room::whereHas('seats',function($q){
                $q->where('available',1);
            })->get();
            return $non_room;
            $non_room = Seat::whereIn('room_id',$rooms->pluck('id'))->where('available',0);
            // 'hostel' => $hostel->get(),
            // $unavailable_seats
            $data = [
                'status' => 'non-available'
            ];
            return $data;
        }
        else{
            $data = [
                'hostel' => $hostel->get(),
                'rooms' => $rooms->get()
            ];
        }
        
        //return $seats->get();
        
        return view('common.room.index',$data);
    }


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

    public function show(string $id)
    {
        $seats = Seat::where('room_id',$id)->orderBy('serial')->get();
        $data = [
            'room' => Room::findOrFail($id),
            'seats' => $seats
        ];
        return view('common.room.show',$data);
    }

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
        $room = Room::findOrFail($id);
        if(Room::where('hostel_id',$room->hostel_id)->where('id','<>',$id)->where('roomno',$request->roomno)->exists()){
            return redirect("/room/$room->id/edit")->with(['message' => ['type' => 'info', 'text' => 'Room No. already exists']])->withInput();
        }
        else{
            $room->update([
                'roomno' => $request->roomno,
                'capacity' => Seat::where('room_id',$room->id)->count(),
                'available' => Seat::where('room_id',$room->id)->sum('available')
            ]);
            return redirect("/room/$room->id")->with(['message' => ['type' => 'info', 'text' => 'Room updated']]);
        }
    }

    public function destroy(string $room_id)
    {
        $room = Room::find($room_id);
        $seats = Seat::where('room_id',$room->id)->get();
        \App\Models\AllotSeat::whereIn('seat_id',$seats->pluck('id'))->delete();
        \App\Models\SeatRemark::whereIn('seat_id',$seats->pluck('id'))->delete();
        RoomRemark::where('room_id',$room->id)->delete();
        Seat::where('room_id',$room->id)->delete();
        $room->delete();
        return "Hello";
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

    public function remarkDelete($id){
        $room = \App\Models\RoomRemark::find($id)->room;
        \App\Models\RoomRemark::find($id)->delete();
        return redirect("/room/$room->id/remark")->with(['message' => ['type' => 'info', 'text' => 'Remark deleted']]);
    }
}
