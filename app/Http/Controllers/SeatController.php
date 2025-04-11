<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AllotSeat;
use App\Models\SeatRemark;
use App\Models\Seat;
use App\Models\Hostel;
use App\Models\Room;

class SeatController extends Controller
{
    public function index(Room $room)
    {
        $seats = Seat::where('room_id',$room->id)->orderBy('serial')->get();
        $data = [
            'seats' => $seats,
            'room' => $room
        ];
        return view('common.seat.index',$data);
    }

    public function create(Room $room)
    {
        return view('common.seat.create',['room' => $room]);
    }

    public function store(Room $room, Request $request)
    {
        if(Seat::where('room_id',$room->id)->where('serial',$request->serial)->exists()){
            return redirect("/room/$room->id/seat/create")->with(['message' => ['type' => 'danger', 'text' => 'Seat serial already exists']])->withInput();
        }

        if(!is_numeric($request->serial)){
            return redirect("/room/$room->id/seat/create")->with(['message' => ['type' => 'danger', 'text' => 'Serial should be numeric value']])->withInput();
        }

        //return $request->available;
        $seat = Seat::create([
            'serial' => $request->serial,
            'room_id' => $room->id,
            'available' => $request->available ? 1:0
        ]);

        if($request->remark){
            SeatRemark::create([
                'seat_id' => $seat->id,
                'remark' => $request->remark,
                'remark_dt' => date('Y-m-d')
            ]);
        }

        Room::where('id',$seat->room_id)->update([
            'capacity' => Seat::where('room_id',$seat->room_id)->count(),
            'available' => Seat::where('room_id',$seat->room_id)->sum('available')
        ]);
        return redirect("/room/$room->id/seat")->with(['message' => ['type' => 'info', 'text' => 'New seat created in']]);

    }

    public function show(string $id)
    {
        $seat = Seat::find($id);
        return view('common.seat.show',['seat' => $seat]);
    }

    public function edit(string $id)
    {
        $seat = Seat::find($id);
        return view('common.seat.edit',['seat' => $seat]);
    }

    public function update(Request $request, string $id)
    {
        $seat = Seat::find($id);
        if(Seat::where('room_id',$seat->room->id)->where('serial',$request->serial)->where('id','<>',$seat->id)->exists()){
            return redirect("seat/$seat->id/edit")->with(['message' => ['type' => 'danger', 'text' => 'Seat serial already exists']])->withInput();
        }

        if(!is_numeric($request->serial)){
            return redirect("seat/$seat->id/edit")->with(['message' => ['type' => 'danger', 'text' => 'Serial should be numeric value']])->withInput();
        }

        //return $request->available;
        if(!$request->available && count($seat->valid_allot_seats()) > 0){
            return redirect("/seat/$seat->id/edit")->with(['message' => ['type' => 'info', 'text' => 'Seat can\'t be made unavailable as it is being allotted']])->withInput();
        }
        $seat->update([
            'serial' => $request->serial,
            'available' => $request->available ? 1:0
        ]);

        Room::where('id',$seat->room_id)->update([
            'capacity' => Seat::where('room_id',$seat->room_id)->count(),
            'available' => Seat::where('room_id',$seat->room_id)->sum('available')
        ]);
        return redirect("/seat/$seat->id")->with(['message' => ['type' => 'info', 'text' => 'Seat updated']]);

    }

    public function destroy(string $id)
    {
        $seat = Seat::find($id);
        $room = Room::find($seat->room_id);

        SeatRemark::where('seat_id',$id)->delete();
        AllotSeat::where('seat_id',$id)->delete();

        $seat->delete();

        $room->update([
            'capacity' => Seat::where('room_id',$room->id)->count(),
            'available' => Seat::where('room_id',$room->id)->sum('available')
        ]);
        return "Success";
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

        AllotSeat::where('allot_hostel_id',request()->allot_hostel_id)->where('valid',1)->update([
            'valid' => 0,
            'leave_dt' => date('Y-m-d'),
            'to_dt' => date('Y-m-d')
        ]);
        
        AllotSeat::create([
            'allot_hostel_id' => request()->allot_hostel_id,
            'seat_id' => $seat_id,
            'from_dt' => date('Y-m-d'),
            'to_dt' => date('Y-m-d'),
            'valid' => 1
        ]);
        return "Success";
    }

    public function remark($id){
        $seat = Seat::findOrFail($id);
        return view('common.seat.remark',['seat' => $seat]);
    }

    public function remarkStore($id){
        \App\Models\SeatRemark::create([
            'seat_id' => $id,
            'remark_dt' => date('Y-m-d'),
            'remark' => request()->remark
        ]);
        return $id;
    }
}
