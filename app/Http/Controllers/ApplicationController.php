<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Person;
use App\Models\Student;
use App\Models\Application;


class ApplicationController extends Controller
{
    public function index()
    {
        return view('application.index');
        // return Application::first();
        if (!auth()->user() || auth()->user()->cannot('viewlist', Application::first())) {
            return redirect('/message')->with(['message' => ['type' => 'warning', 'text' => 'You do not have permission to view applications.']]);
        }
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
        } else {
            $status = 'Applied';
        }
        $applications = Application::where('status', $status)->where('valid', 1)->orderBy('dt')->paginate();

        $data = [
            'applications' => $applications,
            'status' => $status,
        ];

        return view('application.index', $data);
    }


    public function create()
    {
        if (\App\Models\Application::status() == 'open') {
            return view('application.create');
        } else {
            return redirect('/application')->with(['message' => ['type' => 'danger', 'text' => "Application is closed for now"]]);
        }
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'person_id' => '0',
            'name' => 'required|min:4',
            'father' => 'required|min:4',
            'dob' => 'required|date',
            'married' => 'required|numeric',
            'gender' => 'required',
            'mobile' => 'required|numeric',
            'email' => 'required|email',
            'category' => 'required',
            'PWD' => 'required|numeric',
            'state' => 'required|min:3',
            'address' => 'required|min:4',
            'AMC' => 'required|numeric',
            'emergency' => 'required|numeric|min:6',
            'rollno' => '',
            'course' => 'required|numeric',
            'department' => 'required|numeric',
            'semester' => 'required|numeric',
            'mzuid' => 'required|min:6',
            'percent' => 'required|numeric|min:30|max:100'
        ]);
        // return $validated;
        $validated['person_id'] = 0;
        $validated['department'] = \App\Models\Department::find($request->department)->name;
        $validated['course'] = \App\Models\Course::find($request->course)->name;
        $validated['dt'] = now();
        $validated['reason'] = $request->reason;



        if (Application::where('mzuid', $validated['mzuid'])->where('dob', $validated['dob'])->exists()) {
            return redirect()->back()->with(['message' => ['type' => 'warning', 'text' => 'Application already exists.'], 'exists' => '1'])->withInput();
            exit();
        }

        // if ($request->ready == 0) {
        //     return redirect()->back()->withInput()->with(['ready' => 1]);
        //     exit();
        // }
        // return $validated;
        $application = Application::create($validated);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $application->photo = "/storage/" . $path;
        }

        $application->save();

        return redirect('/application')->with(['message' => ['type' => 'info', 'text' => 'Application created successfully. Your MZU ID is: ' . $application->mzuid . ' and your date of birth is ' . $application->dob]]);
    }

    public function show($id)
    {
        // return ['hostels' => \App\Models\Hostel::where('gender','Female')->get()];
        // return auth()->user()->isWardensOf();
        // return "Hello";
        // Logic to show a specific application
        // For example, $application = Application::findOrFail($id);
        $application = Application::findOrFail($id);
        // return $application;
        if ((auth()->user() && auth()->user()->max_role_level() >= 3) || $application->mzuid == $_GET['mzuid']) {
            $prev = DB::select("SELECT * FROM applications WHERE id = (SELECT max(id) FROM applications WHERE id < '" . $application->id . "')");
            $next = DB::select("SELECT * FROM applications WHERE id = (SELECT min(id) FROM applications WHERE id > '" . $application->id . "')");
            // $data = [
            //     'application' => $application,
            //     'prev' => Application::hydrate($prev[0]),
            //     'next' => Application::hydrate($next[0]),
            // ];
            if (auth()->user() && auth()->user()->isWarden()) {
                $hostels = auth()->user()->isWardensOf();
            } else {
                $hostels = \App\Models\Hostel::where('gender', $application->gender)->orderBy('name')->get();
            }
            $data = [
                'application' => $application,
                'prev' => $prev ? $prev[0] : false,
                'next' => $next ? $next[0] : false,
                'hostels' => $hostels,
            ];
            // return $data;
            return view('application.show', $data);
        } else {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }
    }

    public function edit($id)
    {
        // Logic to edit a specific application
        // For example, $application = Application::findOrFail($id);
        $application = Application::findOrFail($id);
        if ($application->mzuid == $_GET['mzuid']) {
            return view('application.edit', ['application' => $application]);
        } else {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }
    }

    public function update(Request $request, $id)
    {

        // return $request;
        $application = Application::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|min:4',
            'father' => 'required|min:4',
            'dob' => 'required|date',
            'married' => 'required|numeric',
            'gender' => 'required',
            'mobile' => 'required|numeric',
            'email' => 'required|email',
            'category' => 'required',
            'PWD' => 'required|numeric',
            'state' => 'required|min:3',
            'address' => 'required|min:4',
            'AMC' => 'required|numeric',
            'emergency' => 'required|numeric|min:6',
            'rollno' => '',
            'course' => 'required|min:2',
            'department' => 'required|min:2',
            'semester' => 'required|numeric',
            'mzuid' => 'required|min:6',
            'percent' => 'required|numeric|min:30|max:100'
        ]);
        $validated['reason'] = $request->reason;
        $application->update($validated);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $application->photo = "/storage/" . $path;
        }
        $application->save();

        return redirect('/application/' . $application->id . "?mzuid=" . $application->mzuid)->with(['message' => ['type' => 'info', 'text' => 'Application updated successfully']]);
    }

    public function statusUpdate(Request $request, $id)
    {
        // return $request->all();
        $application = Application::findOrFail($id);
        // return $request;
        if ($request->has('status')) {
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
            }

            $application->save();
            return redirect('/application/' . $application->id . "?mzuid=" . $application->mzuid)
                ->with(['message' => ['type' => 'info', 'text' => 'Application updated successfully']]);
        } else {
            return redirect('/application/' . $application->id . "?mzuid=" . $application->mzuid)
                ->with(['message' => ['type' => 'warning', 'text' => 'Unknown status!!']]);
        }
        // $application->update($request->all());
        return redirect('/application/' . $application->id . "?mzuid=" . $application->mzuid)->with(['message' => ['type' => 'info', 'text' => 'Application updated successfully']]);
    }

    public function destroy($id)
    {
        if (auth()->user() && auth()->user()->can('delete', Application::findOrFail($id))) {
            $application = Application::findOrFail($id);
            $application->delete();
            return redirect('/application/list')->with(['message' => ['type' => 'info', 'text' => 'Application deleted successfully']]);
        } else {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }
    }

    public function search()
    {
        $data = [
            'dob' => '',
            'mzuid' => '',
        ];
        return view('application.search', $data);
    }

    public function searchStore(Request $request)
    {
        if ($request->type == 'mzuid') {
            $application = Application::where('mzuid', $request->mzuid)->where('dob', $request->dob)->first();
            if ($application) {
                $data = [
                    'application' => $application,
                    'dob' => request()->dob,
                    'mzuid' => request()->mzuid,
                ];
            } else {
                $data = [
                    'dob' => request()->dob,
                    'mzuid' => request()->mzuid,
                ];
            }
        } else { // type=str
            $applications = Application::where('name', 'like', '%' . $request->str . '%')->get();
            if (count($applications) > 0) {
                $data = [
                    'applications' => $applications,
                    'str' => request()->str,
                    'dob' => '',
                    'mzuid' => '',
                ];
            } else {
                $data = [
                    'str' => request()->str,
                    'dob' => '',
                    'mzuid' => '',
                ];
            }
        }
        // return $data;
        return view('application.search', $data);
    }

    public function list()
    {
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
        } else {
            $status = 'Applied';
        }

        $applications = Application::where('status', $status);
        if ($status == 'Approved') {
            if (isset($_GET['hostel']) && $_GET['hostel'] > 0) {
                $applications->where('hostel_id', '<>', 0);
            } else {
                $applications->where('hostel_id', 0);
            }
        }

        $data = [
            'status' => $status,
            'applications' => $applications->paginate(),
        ];
        return view('application.list', $data);
    }

    public function duplicates()
    {
        $duplicates_mzuid = DB::select("select AL.id as allotment_id,A.id as application_id,A.name as application_name,P.name as allotment_name,S.mzuid as mzuid,A.mzuid as application_mzuid, S.course, A.course as application_course, S.department, A.department as application_department
            FROM applications A join (students S JOIN (people P JOIN allotments AL on AL.person_id = P.id) ON S.person_id = P.id) on A.mzuid=S.mzuid");
        $duplicates_mobile = DB::select("select AL.id as allotment_id,A.id as application_id,A.name as application_name,P.name as allotment_name,S.mzuid as mzuid,A.mzuid as application_mzuid, S.course, A.course as application_course, S.department, A.department as application_department
            from applications A join ((people P JOIN allotments AL on AL.person_id = P.id) join students S on P.id=S.person_id) on A.mobile=P.mobile");
        $duplicates_email = DB::select("select AL.id as allotment_id,A.id as application_id,A.name as application_name,P.name as allotment_name,S.mzuid as mzuid,A.mzuid as application_mzuid, S.course, A.course as application_course, S.department, A.department as application_department
            from applications A join ((people P JOIN allotments AL on AL.person_id = P.id) join students S on P.id=S.person_id) on A.email=P.email");
        $duplicates_name = DB::select("select AL.id as allotment_id,A.id as application_id,A.name as application_name,P.name as allotment_name,S.mzuid as mzuid,A.mzuid as application_mzuid, S.course, A.course as application_course, S.department, A.department as application_department
            from applications A join ((people P JOIN allotments AL on AL.person_id = P.id) join students S on P.id=S.person_id) on A.name=P.name");

        $data = [
            'duplicates_mzuid' => $duplicates_mzuid,
            'duplicates_mobile' => $duplicates_mobile,
            'duplicates_email' => $duplicates_email,
            'duplicates_name' => $duplicates_name,
        ];
        return view('application.duplicate', $data);
    }

    public function duplicate($id)
    {

        $application = Application::findOrFail($id);

        $allotments = $application->duplicates();
        // $allotments = $application->existing_allotments();
        return $allotments;
    }

    public function existing($id)
    {
        $application = Application::findOrFail($id);
        $notifications = \App\Models\Notification::where('type', 'allotment')->where('status', 'active')->orderBy('id')->get();


        $data = [
            'application' => $application,
            'notifications' => $notifications,

        ];
        return view('application.existing', $data);
    }

    public function existingStore(Request $request, $id)
    {
        // return $request;
        $application = Application::findOrFail($id);
        // return $application;
        $validated = $request->validate([
            'notification' => 'required',
            'hostel' => 'required',
            'from_dt' => 'required',
            'to_dt' => 'required',
        ]);

        $person = \App\Models\Person::create([
            'name' => $application->name,
            'father' => $application->father,
            'state' => $application->state,
            'category' => $application->category,
            'address' => $application->address,
            'state' => $application->state,
            'mobile' => $application->mobile,
            'email' => $application->email,
            'dob' => $application->dob,
            'photo' => $application->photo,
            'pwd' => $application->pwd ? '1' : '0',
            'gender' => $application->gender,
        ]);

        $student = \App\Models\Student::create([
            'person_id' => $person->id,
            'course' => $application->course,
            'department' => $application->department,
            'mzuid' => $application->mzuid,
            'rollno' => $application->rollno,
        ]);

        $allotment = \App\Models\Allotment::create([
            'person_id' => $person->id,
            'notification_id' => $validated['notification'],
            'hostel_id' => $request->hostel,
            'admitted' => 0,
            'valid' => 1,
            'finished' => 0,
            'from_dt' => $request->from_dt,
            'to_dt' => $request->to_dt,
        ]);

        if ($request->delete_application == 1) {
            $application->delete();
            //return "Hehe";

        }
        return redirect('/allotment/' . $allotment->id)->with(['message' => ['type' => 'info', 'text' => 'Application created successfully']]);
    }

    public function summary()
    {
        $amc = DB::select("SELECT if(amc=1,'Yes','No') as amc, count(*) AS cnt FROM applications GROUP BY amc ORDER BY amc");
        $gender = DB::select("SELECT gender, count(*) AS cnt FROM applications GROUP BY gender ORDER BY gender");
        $state = DB::select("SELECT state, count(*) AS cnt FROM applications GROUP BY state ORDER BY state");
        $course = DB::select("SELECT course, count(*) AS cnt FROM applications GROUP BY course ORDER BY course");
        // return

        $data = [
            'amc' => $amc,
            'gender' => $gender,
            'state' => $state,
            'course' => $course,
        ];

        // return $data;
        return view('application.summary', $data);
        return $tmp;
    }

    public function summary_hostel()
    {
        $hostel_wise = DB::select("SELECT H.name AS hostel, count(if(roomtype=1,1,null)) AS `single`,count(if(roomtype=2,1,null)) AS `double`,count(if(roomtype=3,1,null)) AS `triple`,count(if(roomtype>3,1,null)) AS `dorm`, count(*) as `total`
            FROM applications A LEFT JOIN hostels H ON H.id=A.hostel_id
            WHERE hostel_id <> 0
            GROUP BY H.gender,H.name
            ORDER BY H.gender, H.name;");
        $dept_wise = DB::select("SELECT department, count(*) as cnt
            FROM applications
            WHERE hostel_id <> 0
            GROUP BY department
            ORDER BY department");

        $data = [
            'hostel_wise' => $hostel_wise,
            'dept_wise' => $dept_wise,
        ];
        return view('application.summary-hostel', $data);
    }

    public function priority_list(){
        $applications = Application::where('status','Applied')->orderBy('department')->orderBy('percent','desc')->get();
        $data = [
            'applications' => $applications,
        ];
        return view('application.priority-list',['applications'=>$applications]);
    }

    public function navigate()
    {
        // if(request()->navigation == 'next'){
        //     DB::select("SELECT * FROM ")
        // }
        if (request()->has('application_id')) {
            $id = request()->application_id;
            $application = Application::find($id);
            if ($application) {
                return redirect('/application/' . $application->id . '?mzuid=' . $application->mzuid);
            } else {
                return redirect('/application/list')->with(['message' => ['type' => 'info', 'text' => 'Application id not found']]);
            }
        }
        return redirect('/');
    }
}
