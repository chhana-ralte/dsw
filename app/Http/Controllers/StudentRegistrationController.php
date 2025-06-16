<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Allotment;
use App\Models\Student;
use App\Models\Person;
use App\Models\User;
use App\Models\Role;
use App\Models\Role_User;

class StudentRegistrationController extends Controller
{
    public function registration()
    {
        if (isset(request()->allotment)) {
            $allotment = Allotment::findOrFail(request()->allotment);
            if ($allotment->person->student()) {
                $student = $allotment->person->student();
                $data = [
                    'allotment' => $allotment,
                    'student' => $student
                ];
            } else {
                $data = [
                    'allotment' => $allotment,
                    'student' => ''
                ];
            }

            return view('student_registration.confirm', $data);
        } else {
            return view('student_registration.registration');
        }
    }

    public function registrationStore()
    {
        if (request()->mzuid == "") {
            $mzuid = "98s7t9eut9sreujhtguisdhg";
        } else {
            $mzuid = request()->mzuid;
        }
        if (request()->rollno == "") {
            $rollno = "98s7t9eut9sreujhtguisdhg";
        } else {
            $rollno = request()->rollno;
        }
        $students = Student::where('mzuid', $mzuid)->orWhere('rollno', $rollno);

        if (count($students->get()) == 0) {
            return redirect('/studentRegistration')
                ->with(['message' => ['type' => 'danger', 'text' => 'Information not found. Please contact the Warden to update your profile.']])
                ->withInput();
        } else {
            $persons = Person::whereIn('id', $students->pluck('person_id'));
            $allotments = Allotment::whereIn('person_id', $persons->pluck('id'));
            $data = [
                'allotments' => $allotments->get(),
            ];
            return view('student_registration.multiple', $data);
        }
    }

    public function create_user()
    {
        $allotment = Allotment::findOrFail($_GET['allotment']);
        if ($allotment->user()) {
            $user = $allotment->user();
        } else {
            $user = false;
        }

        if ($allotment->person->student()) {
            $student = $allotment->person->student();
        } else {
            $student = false;
        }

        $data = [
            'user' => $user,
            'allotment' => $allotment,
            'student' => $student,
        ];
        return view('student_registration.create_user', $data);
    }

    public function create_user_store()
    {
        $validated = (object)request()->validate([
            'username' => 'required|min:6',
            'password' => 'required|confirmed|min:6',
            'allotment' => 'required|numeric'
        ]);

        $allotment = Allotment::findOrFail($validated->allotment);

        if (User::where('username', $validated->username)->exists()) {
            return redirect('/studentRegistration/create_user?allotment=' . request()->allotment)
                ->with(['message' => ['type' => 'info', 'text' => 'Username already exists']])
                ->withInput();
        }

        $user = User::create([
            'name' => $allotment->person->name,
            'username' => $validated->username,
            'password' => Hash::make($validated->password),
            // 'email' => $allotment->person->email,
            'person_id' => $allotment->person->id,
        ]);

        $role = Role::updateOrCreate([
            'role' => 'Inmate',
        ], [
            'role' => 'Inmate',
            'level' => '1',
        ]);

        $role_user = Role_User::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
            'type' => 'allotment',
            'foreign_id' => $allotment->id,
        ]);

        return redirect('/login')->with(['message' => ['type' => 'info', 'text' => 'Registration completed. You may login now']]);
    }
}
