<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Person;
use App\Models\Allotment;
use App\Models\AllotHostel;
use App\Models\AllotSeat;
use App\Models\Admission;
use App\Models\Sessn;


class AdmissionCheckController extends Controller
{
    public function index(Allotment $allotment)
    {
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

    public function edit(Admission $admission)
    {
        if (!(auth()->user() && auth()->user()->can('manage', $admission->allotment))) {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }

        $data = [
            'allotment' => $admission->allotment,
            'admission' => $admission,
            'sessns' => \App\Models\Sessn::orderBy('start_yr')->orderBy('odd_even')->get()
        ];
        return view('admissioncheck.edit', $data);
    }

    public function update(Admission $admission)
    {
        if (!(auth()->user() && auth()->user()->can('manage', $admission->allotment))) {
            return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Unauthorised.']]);
            abort(403);
        }
        request()->validate([
            'amount' => 'numeric:required',
            'payment_dt' => 'required',
            'sessn' => 'required',
        ]);

        $admission->update(
            [
                'sessn_id' => request()->sessn,
                'payment_dt' => request()->payment_dt,
                'amount' => request()->amount,
            ]
        );
        return redirect('/allotment/' . $admission->allotment->id . '/admission')
            ->with(['message' => ['type' => 'info', 'text' => 'Admission details updated.']]);
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
