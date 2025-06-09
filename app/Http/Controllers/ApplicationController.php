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
        $data = [
            'applications' => Application::orderBy('dt', 'desc')->get(),
        ];
        // return $data;
        // if (auth()->user() && auth()->user()->can('viewAny', Application::class)) {
        return view('application.index', $data);
        // }
        // If the user cannot view any applications, redirect to the index page with a message
        return redirect()->route('application.index')->with(['message' => ['type' => 'warning', 'text' => 'You do not have permission to view applications.']]);
    }


    public function create()
    {
        return view('application.create');
    }

    public function store(Request $request)
    {
        // if ($request->hasFile('photo')) {
        //     $path = $request->file('photo')->store('photos', 'public');
        //     return "/storage/" . $path;
        // } else {
        //     return "Photo is not present";
        // }
        $request->validate([
            'name' => 'required|min:6',
            'father' => 'required|min:6',
            'gender' => 'required',
            'mobile' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'required|min:6',
            'state' => 'required|min:6',
            'department' => 'required|min:2',
            'course' => 'required|min:2',
            'mzuid' => 'required|min:6',
        ]);

        $person = Person::create([
            'name' => $request->name,
            'father' => $request->father,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'state' => $request->state,
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $person->photo = "/storage/" . $path;
        }
        $person->save();
        $student = Student::create([
            'person_id' => $person->id,
            'department' => $request->department,
            'course' => $request->course,
            'mzuid' => $request->mzuid,
        ]);
        $student->save();
        $application = Application::create([
            'person_id' => $person->id,
            'dt' => now(),
            'status' => 'Applied',
            'valid' => true,
        ]);
        $application->save();

        return redirect('/application')->with(['message' => ['type' => 'info', 'text' => 'Application created successfully.']]);
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
        // Logic to update the application data
        // For example, $application = Application::findOrFail($id);
        // $application->update($request->all());
        return redirect()->route('application.index')->with('success', 'Application updated successfully.');
    }

    public function destroy($id)
    {
        // Logic to delete a specific application
        // For example, $application = Application::findOrFail($id);
        // $application->delete();
        return redirect()->route('application.index')->with('success', 'Application deleted successfully.');
    }
}
