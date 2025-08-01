<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hostel;
use App\Models\Student;
use App\Models\Person;
use App\Models\Allotment;
use App\Models\AllotHostel;
use App\Models\AllotSeat;
use App\Models\Admission;
use App\Models\Sessn;


class HostelAdmissionController extends Controller
{
    public function index(Hostel $hostel)
    {
        if (isset($_GET['sessn'])) {
            $sessn = Sessn::findOrFail($_GET['sessn']);
        } else {
            $sessn = Sessn::current();
        }

        $adm_type = isset($_GET['adm_type']) && $_GET['adm_type'] == 'new' ? 'new' : 'old';

        $allot_hostels = AllotHostel::where('hostel_id', $hostel->id)->where('valid', 1);

        if ($adm_type == 'old') {

            $data = [
                'sessn' => $sessn,
                'allot_hostels' => $allot_hostels->get(),
                'hostel' => $hostel,
                'adm_type' => $adm_type
            ];
            return view("common.admission.hostel-index", $data);
        } else {
            $new_allotments = Allotment::where('hostel_id', $hostel->id)
                ->where('start_sessn_id', \App\Models\Sessn::current()->id);
            $old_allotments = Allotment::where('hostel_id', $hostel->id)
                ->where('start_sessn_id', '<>', \App\Models\Sessn::current()->id)
                ->where('valid', 1)
                ->where('confirmed', 0);
            $data = [
                'sessn' => $sessn,
                'new_allotments' => $new_allotments->get(),
                'old_allotments' => $old_allotments->get(),
                'hostel' => $hostel,
                'adm_type' => $adm_type
            ];
            // return $data;
            return view("common.admission.newadmissionindex", $data);
        }





        // $admissions = $allotment->admissions->orderBy('session_id');
        $admissions = Admission::where('allotment_id', $allotment->id)->orderBy('sessn_id')->get();
        // $admissions->join('sessns', 'sessns.id', 'admissions.sessn_id')->orderBy('sessn_id'); //->orderBy('start_yr')->orderBy('odd_even');
        // $admissions->whereIn('sessn', function ($sessn) {
        //     $sessn->orderBy('start_yr');
        // });
        $data = [
            'allotment' => $allotment,
            'admissions' => $admissions,
        ];
        return view('admissioncheck.index', $data);
    }

    public function create(Allotment $allotment)
    {
        // Shifted to AdmissionController::create

    }

    public function store(Allotment $allotment)
    {
        // Shifted to AdmissionController::store
    }




    public function destroy(Admission $admission)
    {
        $allotment = $admission->allotment;
        $admission->delete();
        return redirect('/allotment/' . $allotment->id . '/admission')
            ->with(['message' => ['type' => 'info', 'text' => 'Admission detail deleted.']]);
    }

    public function check()
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
            return view('admissioncheck.check', $data);
        } else {
            return view('admissioncheck.check');
        }
    }

    public function checkStore()
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
        if (count($students->get()) == 1) {
            $person = $students->first()->person;
            $allotment = $person->valid_allotment();
            return redirect('/admissioncheck?allotment=' . $allotment->id . '&rand=' . uniqid());
        } else if (count($students->get()) == 0) {
            return redirect('/admissioncheck')
                ->with(['message' => ['type' => 'danger', 'text' => 'Information not found']])
                ->withInput();
        } else {
            // return "asdadsa";
            $persons = Person::whereIn('id', $students->pluck('person_id'));
            $allotments = Allotment::whereIn('person_id', $persons->pluck('id'));
            $data = [
                'allotments' => $allotments->get(),
            ];
            return view('admissioncheck.multiple', $data);
        }
    }
}
