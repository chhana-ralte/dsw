<?php

namespace App\Http\Controllers;

use App\Models\Allotment;
use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequirementController extends Controller
{

    public function index(Allotment $allotment)
    {
        // return $allotment;
        $requirements = DB::select("SELECT R.*
            FROM (allotments A JOIN allot_hostels AH ON A.id=AH.allotment_id)
            JOIN requirements R ON R.allot_hostel_id = AH.id
            WHERE A.id = " . $allotment->id . "
            ORDER BY R.id ");
        // return Requirement::hydrate($requirements);


        if ($allotment->valid_allot_hostel() && $allotment->valid_allot_hostel()->valid_allot_seat()) {
            $data = [
                'allotment' => $allotment,
                'allot_hostel' => $allotment->valid_allot_hostel(),
                'allot_seat' => $allotment->valid_allot_hostel()->valid_allot_seat(),
                'requirements' => Requirement::hydrate($requirements),
            ];
            // return $data;
            return view('requirement.index', $data);
        } else if (count($allotment->requirements()) > 0) {
            $data = [
                'allotment' => $allotment,
                'requirements' => Requirement::hydrate($requirements),
            ];
            // return $data;
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
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
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
                    'for_sessn_id' => \App\Models\Sessn::current()->id,
                ],
                [
                    'person_id' => $allotment->person->id,
                    'allot_hostel_id' => $allotment->valid_allot_hostel()->id,
                    'hostel_id' => $allotment->valid_allot_hostel()->hostel->id,
                    'roomcapacity' => $request->roomcapacity,
                    'type' => 'Next Session',
                    'for_sessn_id' => \App\Models\Sessn::current()->id,
                    'dt' => now(),
                    'user_id' => auth()->user()->id,
                ]
            );

            return redirect("/allotment/" . $allotment->id . "/requirement")->with(['message' => ['type' => 'info', 'text' => 'Requirement submitted']]);
        } else {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }
    }



    public function show(Requirement $requirement) {}

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


    public function list()
    {
        // return request()->status;
        if (!(auth()->user() && auth()->user()->can('viewList', \App\Models\Requirement::class))) {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }
        $hostels = \App\Models\Hostel::orderBy('gender')->orderBy('name')->get();
        if (request()->has('hostel_id') && \App\Models\Hostel::find(request()->hostel_id)) {
            $hostel = \App\Models\Hostel::find(request()->hostel_id);
        } else {
            $hostel = false;
        }

        if (request()->has('status')) {
            $status = request()->status;
        } else {
            $status = "Applied";
        }
        if ($status == 'Nothing') {
            $requirements = Requirement::nothing($hostel ? $hostel->id : 0);
        } else if ($status == 'Applied') {
            $requirements = Requirement::applied($hostel ? $hostel->id : 0);
        } else if ($status == 'Resolved') {
            $requirements = Requirement::resolved($hostel ? $hostel->id : 0);
        } else if ($status == 'Notified') {
            $requirements = Requirement::notified($hostel ? $hostel->id : 0);
        }

        $data = [
            'hostels' => $hostels,
            'hostel' => $hostel,
            'requirements' => $hostel ? $requirements->get() : $requirements->paginate()->withQueryString(),
            'status' => $status
        ];
        if ($status == "Nothing") {
            return view('requirement.nothing', $data);
        } else {
            return view('requirement.list', $data);
        }
    }

    public function summary()
    {
        if (!(auth()->user() && auth()->user()->can('viewList', \App\Models\Requirement::class))) {
            return redirect('/');
        }

        $summary = DB::select("SELECT H.name, count(AH.id) AS allot_hostels, count(R.id) AS requirements, count(if(AH.hostel_id = R.hostel_id,1,null)) AS same_hostel, count(if(AH.hostel_id <> R.hostel_id,1,null)) AS diff_hostel,
            count(if(R.new_hostel_id=0,1,null)) AS `applied`,count(if(R.new_hostel_id<>0 AND R.notified=0,1,null)) AS `resolved`,count(if(R.notified=1,0,null)) AS `notified`
            FROM hostels H JOIN allot_hostels AH ON H.id = AH.hostel_id AND AH.valid=1
            LEFT JOIN requirements R ON AH.id = R.allot_hostel_id
            GROUP BY H.name, H.gender
            ORDER BY H.gender, H.name;
        ");
        return view('requirement.summary', ['summary' => $summary]);
    }
    public function listUpdate()
    {


        // return request()->all();
        if (request()->has('hostel_id') && \App\Models\Hostel::find(request()->hostel_id)) {
            $hostel = \App\Models\Hostel::find(request()->hostel_id);
            $hostel_id = $hostel->id;
        } else {
            $hostel = false;
            $hostel_id = 0;
        }

        if (request()->status == 'Applied' && request()->action == 'confirm resolve') {
            $new = array();
            foreach (request()->get('requirement_id') as $id) {
                $requirement = Requirement::find($id);
                $tmp =                    [
                    'hostel_id' => request()->new_hostel_id[$requirement->id],
                    'hostel_name' => \App\Models\Hostel::find(request()->new_hostel_id[$requirement->id])->name,
                    'room_capacity' => request()->new_roomcapacity[$requirement->id],
                    'room_type' => \App\Models\Room::room_type(request()->new_roomcapacity[$requirement->id]),
                ];
                $new[$requirement->id] = $tmp;
            }
            $data = [
                'prev_request' => request()->all(),
                'hostel' => $hostel,
                'status' => 'confirm resolve',
                'requirements' => Requirement::whereIn('id', request()->get('requirement_id'))->get(),
                'new' => $new,
            ];
            // return $data;
            return view('requirement.confirmResolve', $data);
        } else if (request()->status == 'Resolved' && request()->action == 'confirm notify') {
            // return "Hello";
            $requirements = Requirement::whereIn('id', request()->requirement_id);
            // return "Hello";
            $notifications = \App\Models\Notification::where('status', 'active')
                ->where('type', 'sem_allot')
                ->orderBy('dt')->get();
            $data = [
                'requirements' => $requirements->orderBy('new_roomcapacity')->get(),
                'notifications' => $notifications,
                'hostel' => $hostel,
                'status' => 'confirm notify',
            ];
            // return $data;
            return view('requirement.confirmNotify', $data);
        } else if (request()->status == 'confirm notify' && request()->action == 'notify') {
            // return request()->all();
            if (request()->file == 0) {
                $notification = \App\Models\Notification::create([
                    'no' => request()->no,
                    'dt' => request()->dt,
                    'type' => 'sem_allot',
                    'content' => request()->subject,
                ]);
            } else {
                $notification = \App\Models\Notification::findOrFail(request()->file);
            }
            if (count($notification->sem_allots) == 0) {
                $sl = 1;
            } else {
                $sl = $notification->sem_allots->max('sl') + 1;
            }

            $requirements = Requirement::whereIn('id', request()->requirement_id)->orderBy('new_roomcapacity')->get();
            $chars = "ABCDEFGHJKLMNPQRSTUVWXYZ";
            $len = strlen($chars);
            $str = $chars[rand(0, $len - 1)] . $chars[rand(0, $len - 1)];

            foreach ($requirements as $req) {
                $str = $chars[rand(0, $len - 1)] . $chars[rand(0, $len - 1)];
                $semAllot = \App\Models\SemAllot::create([
                    'notification_id' => $notification->id,
                    'requirement_id' => $req->id,
                    'allotment_id' => $req->allot_hostel->allotment->id,
                    'sessn_id' => $req->for_sessn_id,
                    'valid' => 1,
                    'sl' => $sl++,
                    'rand' => $str,
                ]);

                if ($req->allot_hostel->hostel->id != $req->new_hostel_id) {
                    $allotment = $req->allotment;

                    \App\Models\AllotHostel::where('id', $req->allot_hostel_id)->update([
                        'valid' => 0,
                        'to_dt' => date('Y-m-d'),
                        'leave_dt' => date('Y-m-d'),
                    ]);

                    \App\Models\AllotSeat::where('allot_hostel_id', $req->allot_hostel_id)->update([
                        'valid' => 0,
                        'to_dt' => date('Y-m-d'),
                        'leave_dt' => date('Y-m-d'),
                    ]);

                    $allot_hostel = \App\Models\AllotHostel::create([
                        'allotment_id' => $req->allot_hostel->allotment->id,
                        'hostel_id' => $req->new_hostel_id,
                        'from_dt' => date('Y-m-d'),
                        'to_dt' => $req->allot_hostel->allotment->to_dt,
                        'valid' => 1,
                    ]);
                }

                $req->update(['notified' => 1]);
                $req->save();
            }
            return redirect('/requirement/list?hostel_id=' . $hostel_id . '&status=Resolved')
                ->with(['message' => ['type' => 'info', 'text' => 'Requirements updated']]);
        } else if (request()->status == 'confirm resolve' && request()->action == 'resolve') {
            $hostel_id = request()->has('hostel_id') ? request()->hostel_id : 0;
            // return "Hello";
            if (request()->has('requirement_id')) {
                $requirement_ids = request()->get('requirement_id');
                foreach ($requirement_ids as $id) {
                    $requirement = Requirement::find($id);
                    $requirement->update([
                        'new_hostel_id' => request()->get('new_hostel_id')[$id],
                        'new_roomcapacity' => request()->get('new_roomcapacity')[$id],
                    ]);
                }
                return redirect('/requirement/list?hostel_id=' . $hostel_id . '&status=Applied')
                    ->with(['message' => ['type' => 'info', 'text' => 'Requirements updated']]);
            } else {
                return redirect('/hostel/' . $hostel_id . '/requirement_list?status=Applied')
                    ->with(['message' => ['type' => 'info', 'text' => 'Select the students']]);;
            }
        } else if (request()->status == 'Resolved' && request()->action == 'undo resolve') {
            if (request()->has('requirement_id')) {
                $requirement_ids = request()->get('requirement_id');
                Requirement::whereIn('id', $requirement_ids)->update([
                    'notified' => 0,
                    'new_hostel_id' => 0,
                    'new_roomcapacity' => 0,
                ]);
                return redirect('/requirement/list?hostel_id=' . $hostel_id . '&status=' . request()->status)
                    ->with(['message' => ['type' => 'info', 'text' => 'Requirements updated']]);
            } else {
                return redirect('/requirement/list?hostel_id=' . $hostel_id . '&status=' . request()->status)
                    ->with(['message' => ['type' => 'info', 'text' => 'Select the students']]);;
            }
        } else if (request()->status == 'Notified' && request()->action == 'undo notify') {
            if (request()->has('requirement_id')) {
                $requirement_ids = request()->get('requirement_id');
                \App\Models\SemAllot::whereIn('requirement_id', $requirement_ids)->delete();
                Requirement::whereIn('id', $requirement_ids)->update([
                    'notified' => 0,
                ]);
                return redirect('/requirement/list?hostel_id=' . $hostel_id . '&status=' . request()->status)
                    ->with(['message' => ['type' => 'info', 'text' => 'Requirements updated']]);
            } else {
                redirect('/requirement/list?hostel_id=' . $hostel_id . '&status=' . request()->status)
                    ->with(['message' => ['type' => 'info', 'text' => 'Select the students']]);;
            }
        }
    }

    public function duplicate($id)
    {
        $requirement = Requirement::findOrFail($id);
        $applications = $requirement->duplicates();
        return $applications;
    }
}
