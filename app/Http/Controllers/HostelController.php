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
use App\Models\Requirement;


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
        $no_requirement = Requirement::whereIn('allot_hostel_id', $allot_hostels->pluck('id'))->count();
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
            'no_requirement' => $no_requirement,
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

    public function requirement(Hostel $hostel)
    {
        $occupants = $hostel->current_occupants();
        // return $occupants;
        $data = [
            'occupants' => $occupants,
            'hostel' => $hostel,
        ];
        // return $data;
        return view('common.hostel.requirement', $data);
    }

    public function requirementList(Hostel $hostel)
    {
        // return $hostel;
        $allot_hostels = AllotHostel::where('hostel_id', $hostel->id)->where('valid', 1);
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
        } else {
            $status = 'Applied';
        }
        if ($status == 'Applied') {
            $requirements = Requirement::applied($hostel->id);
        } else if($status == 'Resolved'){
            $requirements = Requirement::resolved($hostel->id);

        }
        else{
            $requirements = Requirement::notified($hostel->id);
        }
        $data = [
            'hostel' => $hostel,
            'requirements' => $requirements,
            'status' => $status
        ];
        return view('common.hostel.requirementList', $data);
    }

    public function requirementListUpdate(Hostel $hostel)
    {
        if(request()->status == 'Applied' && request()->action == 'resolve'){
            if (request()->has('requirement_id')) {
                $requirement_ids = request()->get('requirement_id');
                foreach ($requirement_ids as $id) {
                    $requirement = Requirement::find($id);
                    $requirement->update([
                        'new_hostel_id' => request()->get('new_hostel_id')[$id],
                        'new_roomcapacity' => request()->get('new_roomcapacity')[$id],
                    ]);
                }
                return redirect('/hostel/' . $hostel->id . '/requirement_list?status=' . request()->status)
                    ->with(['message' => ['type'=>'info', 'text' => 'Requirements updated']]);
            } else {
                return redirect('/hostel/' . $hostel->id . '/requirement_list?status=' . request()->status)
                    ->with(['message' => ['type'=>'info', 'text' => 'Select the students']]);;
            }

        }
        else if(request()->status == 'Resolved' && request()->action == 'undo resolve'){
            if (request()->has('requirement_id')) {
                $requirement_ids = request()->get('requirement_id');
                Requirement::whereIn('id',$requirement_ids)->update([
                    'new_hostel_id' => 0,
                    'new_roomcapacity' => 0,
                    'notified' => 0,
                ]);
                return redirect('/hostel/' . $hostel->id . '/requirement_list?status=' . request()->status)
                    ->with(['message' => ['type'=>'info', 'text' => 'Requirements updated']]);
            } else {
                return redirect('/hostel/' . $hostel->id . '/requirement_list?status=' . request()->status)
                    ->with(['message' => ['type'=>'info', 'text' => 'Select the students']]);;
            }
        }
        else if(request()->status == 'Resolved' && request()->action == 'notify'){
            if (request()->has('requirement_id')) {
                $requirement_ids = request()->get('requirement_id');
                Requirement::whereIn('id',$requirement_ids)->where('new_hostel_id','<>','0')->where('new_roomcapacity','<>','0')->update([
                    'notified' => 1,
                ]);
                return redirect('/hostel/' . $hostel->id . '/requirement_list?status=' . request()->status)
                    ->with(['message' => ['type'=>'info', 'text' => 'Requirements updated']]);
            } else {
                return redirect('/hostel/' . $hostel->id . '/requirement_list?status=' . request()->status)
                    ->with(['message' => ['type'=>'info', 'text' => 'Select the students']]);;
            }
        }

        else if(request()->status == 'Notified' && request()->action == 'undo notify'){
            if (request()->has('requirement_id')) {
                $requirement_ids = request()->get('requirement_id');
                Requirement::whereIn('id',$requirement_ids)->update([
                    'notified' => 0,
                ]);
                return redirect('/hostel/' . $hostel->id . '/requirement_list?status=' . request()->status)
                    ->with(['message' => ['type'=>'info', 'text' => 'Requirements updated']]);
            } else {
                return redirect('/hostel/' . $hostel->id . '/requirement_list?status=' . request()->status)
                    ->with(['message' => ['type'=>'info', 'text' => 'Select the students']]);;
            }
        }
        else if(request()->status == 'Notified' && request()->action == 'allot'){
            if (request()->has('requirement_id')) {
                $requirement_ids = request()->get('requirement_id');
                $requirements = Requirement::whereIn('id',$requirement_ids)->get();
                foreach($requirements as $req){

                }


                return redirect('/hostel/' . $hostel->id . '/requirement_list?status=' . request()->status)
                    ->with(['message' => ['type'=>'info', 'text' => 'Requirements updated']]);
            } else {
                return redirect('/hostel/' . $hostel->id . '/requirement_list?status=' . request()->status)
                    ->with(['message' => ['type'=>'info', 'text' => 'Select the students']]);;
            }
        }
    }
}
