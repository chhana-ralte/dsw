<?php

namespace App\Http\Controllers;

use App\Models\Allotment;
use App\Models\Requirement;
use Illuminate\Http\Request;

class RequirementController extends Controller
{

    public function index(Allotment $allotment)
    {
        if ($allotment->valid_allot_hostel() && $allotment->valid_allot_hostel()->valid_allot_seat()) {
            $data = [
                'allotment' => $allotment,
                'allot_hostel' => $allotment->valid_allot_hostel(),
                'allot_seat' => $allotment->valid_allot_hostel()->valid_allot_seat(),
                'requirements' => Requirement::where('allot_hostel_id', $allotment->valid_allot_hostel()->id)->get(),
            ];
            return view('requirement.index', $data);
        } else {
            return redirect()->back()->with(['message' => ['type' => 'danger', 'text' => 'You should have valid allotment for hostel and seat to request for requirement']]);
        }
    }

    public function create(Allotment $allotment)
    {
        if ($allotment->valid_allot_hostel() && $allotment->valid_allot_hostel()->valid_allot_seat()) {
            $data = [
                'allotment' => $allotment,
                'allot_hostel' => $allotment->valid_allot_hostel(),
                'allot_seat' => $allotment->valid_allot_hostel()->valid_allot_seat(),
                'requirements' => Requirement::where('allot_hostel_id', $allotment->valid_allot_hostel()->id)->get(),
            ];
            return view('requirement.create', $data);
        } else {
            abort(403);
        }
    }

    public function store(Request $request, Allotment $allotment)
    {
        if ($allotment->valid_allot_hostel() && $allotment->valid_allot_hostel()->valid_allot_seat()) {
            $request->validate([
                'hostel' => 'required'
            ]);

            $requirement = Requirement::updateOrCreate(
                [
                    'person_id' => $allotment->person->id,
                    'for_sessn_id' => \App\Models\Sessn::current()->next()->id,
                ],
                [
                    'person_id' => $allotment->person->id,
                    'allot_hostel_id' => $allotment->valid_allot_hostel()->id,
                    'hostel_id' => $request->hostel,
                    'roomcapacity' => $request->roomcapacity,
                    'type' => 'Next Session',
                    'for_sessn_id' => \App\Models\Sessn::current()->next()->id,
                    'dt' => now(),
                    'user_id' => auth()->user()->id,
                ]
            );

            return redirect("/allotment/" . $allotment->id . "/requirement")->with(['message' => ['type' => 'info', 'text' => 'Requirement submitted']]);
        } else {
            abort(403);
        }
    }



    public function show(Requirement $requirement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requirement $requirement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Requirement $requirement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requirement $requirement)
    {
        //
    }


    public function list(){
        $hostels = \App\Models\Hostel::orderBy('gender')->orderBy('name')->get();
        if(request()->has('hostel_id') && \App\Models\Hostel::find(request()->hostel_id)){
            $hostel = \App\Models\Hostel::find(request()->hostel_id);
            $allot_hostels = \App\Models\AllotHostel::where('hostel_id',$hostel->id)->where('valid',1);
            $requirements = Requirement::whereIn('allot_hostel_id',$allot_hostels->pluck('id'));
        }
        else{
            $hostel = false;
            $requirements = Requirement::orderBy('hostel_id');
        }

        if(request()->has('status')){
            $status = request()->status;
        }
        else{
            $status = "Applied";
        }
        if($status == 'Applied'){
            $requirements->where('new_hostel_id','0')->where('new_roomcapacity', '0');
        }
        else if($status == 'Resolved'){
            $requirements->where('new_hostel_id', '<>', '0')->where('new_roomcapacity', '<>', '0')->where('notified','0');
        }
        else if($status == 'Resolved'){
            $requirements->where('new_hostel_id', '<>', '0')->where('new_roomcapacity', '<>', '0')->where('notified','1');
        }

        $data = [
            'hostels' => $hostels,
            'hostel' => $hostel,
            'requirements' => $requirements->paginate()->withQueryString(),
            'status' => $status
        ];

        // return Requirement::applied($hostel?$hostel->id:0)->paginate();
        return view('requirement.list',$data);
    }

    public function listUpdate()
    {
        // return request()->all();
        if (request()->status == 'Applied' && request()->action == 'resolve') {
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
                    ->with(['message' => ['type' => 'info', 'text' => 'Requirements updated']]);
            } else {
                return redirect('/hostel/' . $hostel->id . '/requirement_list?status=' . request()->status)
                    ->with(['message' => ['type' => 'info', 'text' => 'Select the students']]);;
            }
        }
        else if (request()->status == 'Resolved' && request()->action == 'undo resolve') {
            if (request()->has('requirement_id')) {
                $requirement_ids = request()->get('requirement_id');
                Requirement::whereIn('id', $requirement_ids)->update([
                    'notified' => 0,
                    'new_hostel_id' => 0,
                    'new_roomcapacity' => 0,
                ]);
                return redirect('/hostel/' . $hostel->id . '/requirement_notify?status=' . request()->status)
                    ->with(['message' => ['type' => 'info', 'text' => 'Requirements updated']]);
            } else {
                return redirect('/hostel/' . $hostel->id . '/requirement_notify?status=' . request()->status)
                    ->with(['message' => ['type' => 'info', 'text' => 'Select the students']]);;
            }
        }
        else if (request()->status == 'Resolved' && request()->action == 'notify') {
            if (request()->has('requirement_id') && request()->file != '' && request()->dt != '' && request()->subject != '') {
                $requirement_ids = request()->get('requirement_id');
                $requirements = Requirement::whereIn('id', $requirement_ids)->get();
                $notification = \App\Models\Notification::updateOrCreate([
                    'no' => request()->file,
                    'dt' => request()->dt,
                ], [
                    'no' => request()->file,
                    'dt' => request()->dt,
                    'content' => request()->subject,
                ]);

                foreach ($requirements as $req) {
                    $semAllot = \App\Models\SemAllot::create([
                        'notification_id' => $notification->id,
                        'requirement_id' => $req->id,
                        'allotment_id' => $req->allot_hostel->allotment->id,
                        'sessn_id' => $req->for_sessn_id,
                        'valid' => 1,
                    ]);

                    if ($req->allot_hostel->hostel->id != $req->new_hostel_id) {
                        $allotment = $req->allotment;

                        AllotHostel::where('id', $req->allot_hostel_id)->update([
                            'valid' => 0,
                            'to_dt' => date('Y-m-d'),
                            'leave_dt' => date('Y-m-d'),
                        ]);

                        $allot_hostel = AllotHostel::create([
                            'allotment_id' => $req->allotment->id,
                            'hostel_id' => $req->new_hostel_id,
                            'from_dt' => date('Y-m-d'),
                            'to_dt' => $req->allotment->to_dt,
                            'valid' => 1,
                        ]);
                    }

                    $req->update(['notified' => 1]);
                    $req->save();
                }
                return redirect('/hostel/' . $hostel->id . '/requirement_notify?status=' . request()->status)
                    ->with(['message' => ['type' => 'info', 'text' => 'Requirements updated']]);
            } else {
                return redirect('/hostel/' . $hostel->id . '/requirement_notify?status=' . request()->status)
                    ->with(['message' => ['type' => 'info', 'text' => 'Select the students']]);;
            }
        }

        else if (request()->status == 'Notified' && request()->action == 'undo notify') {
            if (request()->has('requirement_id')) {
                $requirement_ids = request()->get('requirement_id');
                Requirement::whereIn('id', $requirement_ids)->update([
                    'notified' => 0,
                ]);
                return redirect('/hostel/' . $hostel->id . '/requirement_notify?status=' . request()->status)
                    ->with(['message' => ['type' => 'info', 'text' => 'Requirements updated']]);
            } else {
                return redirect('/hostel/' . $hostel->id . '/requirement_notify?status=' . request()->status)
                    ->with(['message' => ['type' => 'info', 'text' => 'Select the students']]);;
            }
        }
    }

}
