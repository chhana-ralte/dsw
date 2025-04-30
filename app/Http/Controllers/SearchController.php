<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Person;
// use App\Models\Student;
use App\Models\Hostel;
use App\Models\AllotHostel;
use App\Models\Allotment;


class SearchController extends Controller
{
    public function index()
    {
        if (Gate::denies('search')) {
            abort(403);
        }
        if (isset(request()->str)) {
            $students = \App\Models\Student::whereLike('rollno', '%' . request()->str . '%')
                ->orWhereLike('course', '%' . request()->str . '%')
                ->orWhereLike('department', '%' . request()->str . '%');

            $persons = Person::whereHas('students', function ($query) use ($students) {
                $query->whereIn('person_id', $students->pluck('person_id'));
            })->orWhereLike('name', '%' . request()->str . '%');

            if (request()->hostel != 0) {
                $allot_hostels = AllotHostel::where('hostel_id', request()->hostel);
                $allotments = Allotment::whereIn('id', $allot_hostels->pluck('allotment_id'));
                $persons->whereIn('id', $allotments->pluck('person_id'));
            }
            $data = [
                'persons' => $persons->get(),
                'str' => request()->str,
                'hostel' => request()->hostel,
            ];
        } else {
            $data = [
                'persons' => [],
                'str' => '',
                'hostel' => 0,
            ];
        }
        return view('search', $data);
    }
}
