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
        // return $hostel;

        // $rooms = Room::where('hostel_id', $hostel->id)->orderBy('roomno');
        $rooms = $hostel->rooms();
        $seats = Seat::whereIn('room_id', $rooms->pluck('id'));
        $allot_seats = AllotSeat::whereIn('seat_id', $seats->pluck('id'))->where('valid', 1);
        if (request('status') == 'vacant') {
            $rooms->whereHas('seats', function ($seats) use ($allot_seats) {
                $seats->whereNotIn('id', $allot_seats->pluck('seat_id'));
            });
        }
        if (request('status') == 'non-available') {
            $rooms->whereHas('seats', function ($seats) use ($allot_seats) {
                $seats->whereIn('id', $allot_seats->pluck('seat_id'));
            });
        }

        // $allotted_seats = Seat::whereIn('id', $allot_seats->pluck('seat_id'));

        // $vacant_seats = $seats->whereNotIn('id', $allotted_seats->pluck('id'));
        // if (isset($_GET['status']) && $_GET['status'] == 'vacant') {
        //     $vacant_seats = $seats->whereNotIn('id', $allotted_seats->pluck('id'));
        //     $data = [
        //         'hostel' => $hostel,
        //         'vacant_seats' => $vacant_seats->get(),
        //         'status' => 'vacant'
        //     ];
        //     //return $data;
        // } else if (isset($_GET['status']) && $_GET['status'] == "non-available") {
        //     $rooms = $hostel->rooms;
        //     $allotted_seats = Seat::whereIn('id', $allot_seats->pluck('seat_id'));
        //     $non_rooms = $seats->whereIn('id', $allotted_seats->pluck('id'));
        //     // $non_rooms = Room::where('hostel_id',$hostel->id)->where('capacity',0)->orWhere('available',0);
        //     // $non_seats = Seat::whereIn('room_id',$rooms->pluck('id'))->where('available',0)->whereNotIn('room_id',$non_rooms->pluck('id'));
        //     $data = [
        //         'hostel' => $hostel,
        //         'non_rooms' => $non_rooms->get(),
        //         // 'non_rooms' => $non_rooms->orderBy('roomno')->get(),
        //         'non_seats' => $allotted_seats->orderBy('serial')->get(),
        //         'status' => 'non-available'
        //     ];
        //     //return "Heklo";
        //     //return $data;
        // } else {
        //     $data = [
        //         'hostel' => $hostel,
        //         'rooms' => $rooms->get(),
        //         'status' => 'all'
        //     ];
        //     //return $data;
        // }


        $data = [
            'hostel' => $hostel,
            'rooms' => $rooms->get(),
            'status' => 'all'
        ];

        //return $seats->get();

        return view('common.room.index', $data);
    }


    public function create(Hostel $hostel)
    {
        return view('common.room.create', ['hostel' => $hostel]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Hostel $hostel, Request $request)
    {

        if (Room::where('hostel_id', $hostel->id)->where('roomno', $request->roomno)->exists()) {
            return redirect("/hostel/$hostel->id/room/create")->with(['message' => ['type' => 'danger', 'text' => 'Room number already exists']])->withInput();
        }

        if (!is_numeric($request->capacity)) {
            return redirect("/hostel/$hostel->id/room/create")->with(['message' => ['type' => 'danger', 'text' => 'Capacity should be numeric value']])->withInput();
        }

        //return $request->available;
        $room = Room::create([
            'roomno' => $request->roomno,
            'hostel_id' => $hostel->id,
            'capacity' => $request->capacity,
            'available' => $request->capacity,
            'type' => $request->capacity == 1 ? 'Single' : ($request->capacity == 2 ? 'Double' : ($request->capacity == 3 ? 'Triple' : 'Dorm'))
        ]);

        if ($request->remark) {
            RoomRemark::create([
                'room_id' => $room->id,
                'remark' => $request->remark,
                'remark_dt' => date('Y-m-d')
            ]);
        }

        for ($i = 0; $i < $room->capacity; $i++) {
            Seat::create([
                'room_id' => $room->id,
                'available' => 1,
                'serial' => $i + 1
            ]);
        }

        return redirect("/room/$room->id")->with(['message' => ['type' => 'info', 'text' => 'New room created']]);
    }

    public function show(string $id)
    {
        $seats = Seat::where('room_id', $id)->orderBy('serial')->get();
        $data = [
            'room' => Room::findOrFail($id),
            'seats' => $seats
        ];
        return view('common.room.show', $data);
    }

    public function edit(string $id)
    {

        $seats = Seat::where('room_id', $id)->orderBy('serial')->get();
        $data = [
            'room' => Room::findOrFail($id),
            'seats' => $seats
        ];
        return view('common.room.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);
        if (Room::where('hostel_id', $room->hostel_id)->where('id', '<>', $id)->where('roomno', $request->roomno)->exists()) {
            return redirect("/room/$room->id/edit")->with(['message' => ['type' => 'info', 'text' => 'Room No. already exists']])->withInput();
        } 
        else {
            $room->update([
                'roomno' => $request->roomno,
                'capacity' => Seat::where('room_id', $room->id)->count(),
                'available' => Seat::where('room_id', $room->id)->sum('available')
            ]);
            return redirect("/room/$room->id")->with(['message' => ['type' => 'info', 'text' => 'Room updated']]);
        }
    }

    public function destroy(string $room_id)
    {
        $room = Room::find($room_id);
        $seats = Seat::where('room_id', $room->id)->get();
        \App\Models\AllotSeat::whereIn('seat_id', $seats->pluck('id'))->delete();
        \App\Models\SeatRemark::whereIn('seat_id', $seats->pluck('id'))->delete();
        RoomRemark::where('room_id', $room->id)->delete();
        Seat::where('room_id', $room->id)->delete();
        $room->delete();
        return "Hello";
    }

    public function remark($id)
    {
        $room = Room::findOrFail($id);
        return view('common.room.remark', ['room' => $room]);
    }

    public function remarkStore($id)
    {
        \App\Models\RoomRemark::create([
            'room_id' => $id,
            'remark_dt' => date('Y-m-d'),
            'remark' => request()->remark
        ]);
        return $id;
    }

    public function remarkDelete($id)
    {
        $room = \App\Models\RoomRemark::find($id)->room;
        \App\Models\RoomRemark::find($id)->delete();
        return redirect("/room/$room->id/remark")->with(['message' => ['type' => 'info', 'text' => 'Remark deleted']]);
    }

    public function unavailable($id){
        //return $id;
        $room = Room::find($id);
        $seats = Seat::where('room_id',$room->id);
        \App\Models\AllotSeat::whereIn('seat_id',$seats->pluck('id'))->where('valid',1)
            ->update([
            'valid' => 0,
            'to_dt' => date('Y-m-d')
        ]);
        $seats->update([
            'available' => 0
        ]);
        $room->update([
            'available' => 0
        ]);
        return redirect("/room/" . $room->id . "/edit")->with(['message' => ['type' => "info", 'text' => "Room is made unavailable"]]);
    }

    public function editseatavailability($room_id){
        //return $room_id;
        $room = Room::find($room_id);
        $seats = Seat::where('room_id', $room->id)->orderBy('serial')->get();
        return view('common.room.editseatavailability',['room' => $room, 'seats' => $seats]);
    }

    public function updateseatavailability(Request $request,$room_id){
        foreach($request->request as $key => $value){
            $arr = explode('_',$key);
            if($arr[0] == "available"){
                Seat::find($arr[1])->update(['available' => $value]);
                if($value == 0){
                    AllotSeat::where('seat_id',$arr[1])->where('valid',1)->update(['valid' => 0, 'to_dt' => date('Y-m-d')]);
                }
            }
        }
        Room::find($room_id)->update([
            'available' => Seat::where('room_id',$room_id)->where('available',1)->count()
        ]);
        return redirect("/room/" . $room_id . "/seat")->with(['message' => ['type' => "info", 'text' => "Availability updated"]]);;
    }
}
