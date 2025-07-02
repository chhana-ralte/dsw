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
        return view('application.create');
    }

    public function store(Request $request)
    {
        // return $request->has('AMC')?'Yes':'No';
        // return $request;
        // if ($request->hasFile('photo')) {
        //     $path = $request->file('photo')->store('photos', 'public');
        //     return "/storage/" . $path;
        // } else {
        //     return "Photo is not present";
        // }
        // return $request->photo;
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

        if ($request->ready == 0) {
            return redirect()->back()->withInput()->with(['ready' => 1]);
            exit();
        }
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
        // return "Hello";
        // Logic to show a specific application
        // For example, $application = Application::findOrFail($id);
        $application = Application::findOrFail($id);
        // return $application;
        if ($application->mzuid == $_GET['mzuid']) {
            return view('application.show', ['application' => $application]);
        } else {
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
        $application = Application::findOrFail($id);
        // return $request;
        if ($request->has('status')) {
            if ($request->status == 'approve') {
                $application->update(['status' => 'Approved']);
            } else if ($request->status == 'decline') {
                $application->update(['status' => 'Declined']);
            } else if ($request->status == 'pending') {
                $application->update(['status' => 'Pending']);
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

        $application = Application::where('mzuid', $request->mzuid)->where('dob', $request->dob)->first();
        if ($application) {
            $data = [
                'application' => $application,

            ];
        } else {
            $data = [
                'dob' => request()->dob,
                'mzuid' => request()->mzuid,
            ];
        }
        return view('application.search', $data);
    }

    public function list()
    {
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
        } else {
            $status = 'Applied';
        }

        $applications = Application::where('status', $status)->orderBy('id');
        $data = [
            'status' => $status,
            'applications' => $applications->paginate(),
        ];
        return view('application.list', $data);
    }

    public function duplicate()
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
}
