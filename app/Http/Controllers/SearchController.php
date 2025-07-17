<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

use App\Models\Person;
// use App\Models\Student;
use App\Models\Hostel;
use App\Models\AllotHostel;
use App\Models\Allotment;


class SearchController extends Controller
{
    public function index()
    {
        // return "ASASS";
        if (Gate::denies('search')) {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }
        if (isset(request()->str)) {
            if (request()->has('hostel') && request()->hostel != 0) {
                // $hostel = Hostel::find(request()->hostel);


                $result = DB::select("SELECT P.id AS person_id, A.id AS allotment_id, AH.valid AS valid_allot_hostel, AH.id AS allot_hostel_id, P.name, S.course, S.mzuid, S.department, S.id as student_id
                FROM `people` P JOIN allotments A ON P.id=A.person_id
                LEFT JOIN students S ON P.id=S.person_id
                LEFT JOIN others O ON P.id=O.person_id
                LEFT JOIN allot_hostels AH ON A.id=AH.allotment_id
                WHERE (S.mzuid = '" . request()->str . "' OR P.name LIKE '%" . request()->str . "%')
                AND (AH.hostel_id = '" . request()->hostel . "' OR A.hostel_id = '" . request()->hostel . "')");
            } else {
                $hostel = false;
                $result = DB::select("SELECT P.id AS person_id, A.id AS allotment_id, AH.valid AS valid_allot_hostel, AH.id AS allot_hostel_id, P.name, S.course, S.mzuid, S.department, S.id as student_id
                FROM `people` P JOIN allotments A ON P.id=A.person_id
                LEFT JOIN students S ON P.id=S.person_id
                LEFT JOIN others O ON P.id=O.person_id
                LEFT JOIN allot_hostels AH ON A.id=AH.allotment_id
                WHERE S.mzuid = ' . request()->str . '
                OR P.name LIKE '%" . request()->str . "%'");
            }

            $result = \App\Models\SearchResult::hydrate($result);

            $data = [
                'search_results' => $result,
                'str' => request()->str,
                'hostel' => request()->hostel,
            ];
            // return $data;
            return view('search2', $data);


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
