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
        // return "asdsadasd";
        if (!auth()->user() && auth()->user()->can('manage', $allotment)) {
            abort(403);
        }

        if(count($allotment->allot_hostels)>0){
            $data = [
            'allotment' => $allotment,
            'sessns' => \App\Models\Sessn::orderBy('start_yr')->orderBy('odd_even')->get(),
            ];
            // return view('common.admission.create',$data);
            return view('admissioncheck.create', $data);
        }
        else{ // new admission
            if (isset($_GET['sessn_id'])) {
                $sessn = Sessn::findOrFail($_GET['sessn_id']);
            } else {
                $sessn = Sessn::default();
            }
            $data = [
                'admissions' => Admission::where('allotment_id', $allotment->id)->get(),
                'allotment' => $allotment,
                'sessn' => $sessn
            ];
            return view('common.admission.create', $data);
        }




        return $allotment;
    }

    public function store(Allotment $allotment)
    {
        if (!auth()->user() && auth()->user()->can('manage', $allotment)) {
            abort(403);
        }

        if(request()->type && request()->type == 'new'){
            // return "Hello";


            $allot_hostel = AllotHostel::updateOrCreate(
                [
                    'allotment_id' => $allotment->id,
                    'hostel_id' => $allotment->hostel->id,
                    'valid' => 1,
                ],
                [
                    'allotment_id' => $allotment->id,
                    'hostel_id' => $allotment->hostel->id,
                    'valid' => 1,
                    'from_dt' => $allotment->from_dt,
                    'to_dt' => $allotment->to_dt,
                ]
            );


            $allot_seat = AllotSeat::updateOrCreate(
                [
                    'allot_hostel_id' => $allot_hostel->id,
                    'seat_id' => request()->seat,
                ],
                [
                    'allot_hostel_id' => $allot_hostel->id,
                    'seat_id' => request()->seat,
                    'valid' => 1,
                    'from_dt' => $allot_hostel->from_dt,
                    'to_dt' => $allot_hostel->to_dt,
                ]
            );

            if (request()->admitted) {
                Admission::updateOrCreate(
                    [
                        'allotment_id' => $allotment->id,
                        'sessn_id' => request()->sessn_id,
                        'allot_hostel_id' => $allot_hostel->id,
                    ],
                    [
                        'allotment_id' => $allotment->id,
                        'sessn_id' => request()->sessn_id,
                        'allot_hostel_id' => $allot_hostel->id,
                    ]
                );

                $allotment->update([
                    'admitted' => 1
                ]);
            }
        }

        else{



            request()->validate([
                'amount' => 'numeric:required',
                'payment_dt' => 'required',
                'sessn' => 'required',
            ]);

            if ($allotment->valid_allot_hostel()) {
                $allot_hostel_id = $allotment->valid_allot_hostel()->id;
            } else {
                $allot_hostel_id = 0;
            }
            Admission::updateOrCreate(
                [
                    'sessn_id' => request()->sessn,
                    'allotment_id' => $allotment->id,
                ],
                [
                    'sessn_id' => request()->sessn,
                    'allotment_id' => $allotment->id,
                    'payment_dt' => request()->payment_dt,
                    'amount' => request()->amount,
                    'allot_hostel_id' => $allot_hostel_id,
                ]
            );
        }
        return redirect('/allotment/' . $allotment->id . '/admission')
            ->with(['message' => ['type' => 'info', 'text' => 'Admission detail created.']]);
    }

    public function edit(Admission $admission)
    {
        if (!auth()->user() && auth()->user()->can('manage', $allotment)) {
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
        if (!auth()->user() && auth()->user()->can('manage', $allotment)) {
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

    public function destroy(Admission $admission){
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
