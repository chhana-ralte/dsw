<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Person;
use App\Models\Student;
use App\Models\Application;


class ApplController extends Controller
{
    public function toggleStatus()
    {
        if (\App\Models\Manage::where('name', 'allotment')->first()->status == 'open') {
            \App\Models\Manage::where('name', 'allotment')->update(['status' => 'closed']);
            return "Allotment closed";
        } else {
            \App\Models\Manage::where('name', 'allotment')->update(['status' => 'open']);
            return "Allotment opened";
        }
    }

    public function search()
    {
        return view('appl.search');
    }

    public function searchStore(Request $request)
    {

        $applications = Application::where('name', 'like', '%' . $request->str . '%')->get();
        if (count($applications) > 0) {
            $data = [
                'applications' => $applications,
                'str' => request()->str,

            ];
        } else {
            $data = [
                'str' => request()->str,
            ];
        }

        // return $data;
        return view('appl.search', $data);
    }

    public function index()
    {
        $sql = "SELECT state, count(if(gender='Male',1,NULL)) AS male, count(if(gender='Female',1,NULL)) AS female
            FROM applications GROUP BY state ORDER BY count(*) DESC";
        $states = DB::select($sql);
        $sql = "SELECT departments.id AS id, departments.name AS department, count(if(gender='Male',1,NULL)) AS male, count(if(gender='Female',1,NULL)) AS female
            FROM applications JOIN departments ON applications.department_id = departments.id
            GROUP BY departments.id, departments.name
            ORDER BY departments.name";
        $departments = DB::select($sql);
        $data = [
            'states' => $states,
            'departments' => $departments,
        ];

        return view("appl.index", $data);
    }

    public function list($status)
    {
        // return $status;
        $statuses = DB::select("SELECT distinct status FROM applications");
        if ($status == 'All') {
            $applications = Application::where('admitted', 0)->orderBy('id');
        } else {
            $applications = Application::where('status', $status)->orderBy('id');
        }
        $applications_count = $applications->count();
        $applications = $applications->paginate();
        $data = [
            'applications_count' => $applications_count,
            'status' => $status,
            'statuses' => $statuses,
            'applications' => $applications
        ];

        // return $data;
        return view('appl.list', $data);
    }

    public function show(Application $application)
    {

        $hostels = \App\Models\Hostel::where('gender', $application->gender)
            ->orderBy('name')
            ->get();

        $data = [
            'application' => $application,
            'hostels' => $hostels,
        ];
        return view('appl.show', $data);
    }

    public function department(\App\Models\Department $department)
    {
        $applications = Application::where('department_id', $department->id)
            ->where('status', '<>', 'Admitted')
            ->where('status', '<>', 'Declined')
            ->where('valid', 1)
            ->orderBy('total_score', 'desc')
            ->orderBy('id')
            ->get();
        $females = Application::where('gender', 'Female')
            ->where('department_id', $department->id)
            ->orderBy('total_score', 'desc')
            ->orderBy('id')
            ->get();

        $data = [
            'applications' => $applications,
            'females' => $females,
            'department' => $department,
        ];
        return view('appl.department', $data);
    }

    public function hostel(\App\Models\Hostel $hostel)
    {
        $applications = Application::where('hostel_id', $hostel->id)
            ->where('status', 'Approved')
            ->where('valid', 1)
            ->orderBy('roomtype')
            ->get();

        $data = [
            'applications' => $applications,
            'hostel' => $hostel,
        ];
        return view('appl.hostel', $data);
    }

    public function statusUpdate(Request $request, $id)
    {
        // return "Hello";
        // return $request->all();
        $application = Application::findOrFail($id);
        // return $request;
        if ($request->has('status')) {
            if ($application->status == 'Notified') {
                // If already notified, previous allotment records are to be invalidated/Deleted //
                $allotments = \App\Models\Allotment::where('application_id', $application->id)->get();
                $allot_hostels = \App\Models\AllotHostel::whereIn('allotment_id', $allotments->pluck('id'))->get();
                $allot_seats = \App\Models\AllotSeat::whereIn('allot_hostel_id', $allot_hostels->pluck('id'))->get();
                if (count($allot_hostels) == 0) {
                    $people = \App\Models\Person::whereIn('id', $allotments->pluck('person_id'))->get();
                    \App\Models\Student::whereIn('person_id', $people->pluck('id'))->delete();
                    \App\Models\Other::whereIn('person_id', $people->pluck('id'))->delete();
                    \App\Models\Person::whereIn('id', $allotments->pluck('person_id'))->delete();
                    \App\Models\AllotSeat::whereIn('allot_hostel_id', $allot_hostels->pluck('id'))->delete();
                    \App\Models\AllotHostel::whereIn('id', $allot_hostels->pluck('id'))->delete();
                    \App\Models\Allotment::where('application_id', $application->id)->delete();
                } else {
                    \App\Models\Allotment::where('application_id', $application->id)->update([
                        'valid' => 0
                    ]);
                    \App\Models\AllotHostel::where('allotment_id', $allotments->pluck('id'))->update([
                        'valid' => 0
                    ]);
                    \App\Models\AllotSeat::where('allot_hostel_id', $allot_hostels->pluck('id'))->update([
                        'valid' => 0
                    ]);
                }
            }

            if ($request->status == 'approve') {
                $application->update([
                    'status' => 'Approved',
                    'hostel_id' => 0,
                    'roomtype' => 0,
                ]);
            } else if ($request->status == 'decline') {
                $application->update([
                    'status' => 'Declined',
                    'hostel_id' => 0,
                    'roomtype' => 0,
                ]);
            } else if ($request->status == 'pending') {
                $application->update([
                    'status' => 'Pending',
                    'hostel_id' => 0,
                    'roomtype' => 0,
                ]);
            } else if ($request->status == 'approve-hostel') {
                $application->update([
                    'status' => 'Approved',
                    'hostel_id' => $request->hostel_id,
                    'roomtype' => $request->roomtype,
                ]);
            } else {
                // Do nothing
            }

            $application->save();

            if (request()->has('ajax') && request()->ajax == 1) {
                return "success";
            } else {
                return redirect('/appl/' . $application->id)
                    ->with(['message' => ['type' => 'info', 'text' => 'Application updated successfully']]);
            }
        } else {
            return redirect('/appl/' . $application->id)
                ->with(['message' => ['type' => 'warning', 'text' => 'Unknown status!!']]);
        }
        // $application->update($request->all());
        return redirect('/appl/' . $application->id)->with(['message' => ['type' => 'info', 'text' => 'Application updated successfully']]);
    }

    public function allotment_summary()
    {
        $hostel_data = $this->build_data();
        // return $hostel_data['appl_data'][1]->name;
        // return $results;

        $sql = "SELECT department, count(if(gender='Male',1,NULL)) AS male, count(if(gender='Female',1,NULL)) AS female
            FROM applications
            WHERE status = 'Approved'
            GROUP BY department
            ORDER BY department";
        $departments = DB::select($sql);

        $sql = "SELECT hostels.id, hostels.name as hostel, applications.roomtype AS roomcapacity, count(*) AS cnt
            FROM applications JOIN hostels ON hostels.id=applications.hostel_id
            WHERE status = 'Approved'
            GROUP BY hostels.id, hostels.name, hostels.gender, applications.roomtype
            ORDER BY  hostels.gender, hostels.name";
        $hostels = DB::select($sql);

        $sql = "SELECT count(if(gender='Male',1,NULL)) AS male, count(if(gender='Female',1,NULL)) AS female
            FROM applications
            WHERE status='Approved' AND hostel_id=0";
        $no_hostel = DB::select($sql);
        $no_hostel = $no_hostel[0];

        $sql = "select hostels.id AS hostel_id,hostels.name AS Hostel, rooms.capacity AS roomcapacity, if(rooms.capacity=1,'Single',if(rooms.capacity=2,'Double',if(rooms.capacity=3,'Triple','Dorm'))) AS Type, count(if(seats.available,1,NULL)) AS Total,count(if(allot_seats.id,1,NULL)) AS Occupied, count(if(seats.available,1,NULL))-count(if(allot_seats.id,1,NULL)) AS Vacant
            from hostels join rooms on hostels.id=rooms.hostel_id AND rooms.capacity <> 0
            join seats on rooms.id=seats.room_id
            left join allot_seats on seats.id=allot_seats.seat_id and allot_seats.valid=1
            group by hostels.gender,hostels.id,hostels.name, rooms.capacity
            order by hostels.gender,hostels.name";
        $vacancies = DB::select($sql);

        // return $vacancies;
        $data = [
            'hostels' => $hostels,
            'departments' => $departments,
            'no_hostel' => $no_hostel,
            'vacancies' => $vacancies,
            'hostel_data' => $hostel_data
        ];
        // return $data;
        return view('appl.allotment_summary', $data);
        return $departments;
    }

    private function build_data(){
        return "Hello";
        $hostels = \App\Models\Hostel::orderBy('gender')->orderBy('name')->get();

        $sql = "SELECT hostels.id, hostels.name, count(*) AS total, count(if(roomtype=1,1,NULL)) AS Single, count(if(roomtype=2,1,NULL)) AS `Double`, count(if(roomtype=3,1,NULL)) AS Triple, count(if(roomtype>3,1,NULL)) AS Dorm
            FROM applications JOIN hostels ON hostels.id=applications.hostel_id
            WHERE applications.status='Approved'
            GROUP BY hostels.id,hostels.gender,hostels.name
            ORDER BY hostels.gender,hostels.name";
        $appl_data = DB::select($sql);
        $appl_arr = [];
        foreach($appl_data as $row){
            $appl_arr[$row->id] = $row;
        }

        // return $appl_arr;

        $sql = "SELECT hostels.id, hostels.name, count(allot_hostels.id) as occupied, count(allot_seats.id) as seats, count(if(rooms.capacity=1,1,NULL)) AS Single, count(if(rooms.capacity=2,1,NULL)) AS `Double`, count(if(rooms.capacity=3,1,NULL)) AS Triple, count(if(rooms.capacity>3,1,NULL)) AS Dorm
            FROM hostels JOIN allot_hostels ON hostels.id=allot_hostels.hostel_id AND allot_hostels.valid=1
            LEFT JOIN (allot_seats JOIN seats ON seats.id=allot_seats.seat_id AND allot_seats.valid=1 JOIN rooms ON rooms.id=seats.room_id)
            ON allot_hostels.id=allot_seats.allot_hostel_id AND allot_seats.valid=1
            GROUP BY hostels.id,hostels.gender,hostels.name
            ORDER BY hostels.gender,hostels.name";
        $hos_data = DB::select($sql);
        $hos_arr = [];
        foreach($hos_data as $row){
            $hos_arr[$row->id] = $row;
        }
        $results = [
            'appl_data' => $appl_arr,
            'hos_data' => $hos_arr
        ];
        return $results;
    }

    public function destroy(Application $application)
    {
        $department_id = $application->department_id;
        $application->delete();
        return ['department_id' => $department_id];
    }

    public function allotted()
    {
        if (isset(request()->hostel_id)) {
            $hostel = \App\Models\Hostel::findOrFail(request()->hostel_id);
            $hostels = \App\Models\Hostel::where('gender', $hostel->gender)->orderBy('name')->get();
            $allotted = Application::where('status', 'Approved')->where('hostel_id', $hostel->id)->get();
        } else {
            if (isset(request()->gender)) {
                $hostels = \App\Models\Hostel::where('gender', request()->gender)->orderBy('name')->get();
                $allotted = Application::where('gender', request()->gender)->where('status', 'Approved')->where('hostel_id', 0)->get();
            } else {
                $hostels = \App\Models\Hostel::orderBy('gender')->orderBy('name')->get();
                $allotted = Application::where('status', 'Approved')->where('hostel_id', 0)->get();
            }
            $hostel = null;
        }
        $data = [
            'hostels' => $hostels,
            'allotted' => $allotted,
            'hostel' => $hostel,
            'back_link' => '/appl/allotment_summary',
        ];
        // return $data;
        return view('appl.allotted', $data);
    }
    public function navigate()
    {
        if (request()->has('application_id')) {
            $id = request()->application_id;
            $application = Application::find($id);
            if ($application) {
                return redirect('/appl/' . $application->id);
            } else {
                return redirect('/appl/list')->with(['message' => ['type' => 'info', 'text' => 'Application id not found']]);
            }
        }
    }
}
