<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Person;
use App\Models\Student;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function index()
    {
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
        $validated = $request->validate([
            'person_id' => '0',
            'name' => 'required|min:6',
            'father' => 'required|min:6',
            'dob' => 'required|date',
            'married' => 'required|numeric',
            'gender' => 'required',
            'mobile' => 'required|numeric',
            'email' => 'required|email',
            'category' => 'required',
            'PWD' => 'required|numeric',
            'state' => 'required|min:3',
            'address' => 'required|min:6',
            'AMC' => 'required|numeric',
            'emergency' => 'required|numeric|min:6',
            'rollno' => '',
            'course' => 'required|min:2',
            'department' => 'required|min:2',
            'semester' => 'required|numeric',
            'mzuid' => 'required|min:6',
            'percent' => 'required|numeric|min:30|max:100'
        ]);
        // return $validated;
        $validated['person_id'] = 0;
        $validated['dt'] = now();

        if (Application::where('mzuid', $validated['mzuid'])->where('dob', $validated['dob'])->exists()) {
            return redirect()->back()->with(['message' => ['type' => 'warning', 'text' => 'Application already exists.'], 'exists' => '1'])->withInput();
            exit();
        }
        $application = Application::create($validated);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $application->photo = "/storage/" . $path;
        }


        $application->save();

        return redirect('/message')->with(['message' => ['type' => 'info', 'text' => 'Application created successfully. Your application ID is: ' . $application->id]]);
    }

    public function show($id)
    {
        // Logic to show a specific application
        // For example, $application = Application::findOrFail($id);
        $application = Application::findOrFail($id);
        return view('application.show', ['application' => $application]);
    }

    public function edit($id)
    {
        // Logic to edit a specific application
        // For example, $application = Application::findOrFail($id);
        return view('application.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        if ($request->has('status')) {
            $application->update(['status' => $request->status]);
            $application->save();
            return redirect('/application/' . $application->id)->with('success', 'Application updated successfully.');
        } else {
            return "Nothing";
        }
        // $application->update($request->all());
        return redirect()->route('application.index')->with('success', 'Application updated successfully.');
    }

    public function destroy($id)
    {
        if (auth()->user() && auth()->user()->can('delete', Application::findOrFail($id))) {
            $application = Application::findOrFail($id);
            $application->delete();
            return redirect()->route('application.index')->with('success', 'Application deleted successfully.');
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
}
