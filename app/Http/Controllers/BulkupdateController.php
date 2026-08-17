<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Application;
use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BulkupdateController extends Controller
{
    public function index()
    {
        if (request()->has('filter')) {
            if (request()->filter == 'all') {
                $sql = "SELECT payment_list.id,payment_list.name, payment_list.amount, payment_list.course, applications.name as appl_name, payment_list.application_id
                    FROM payment_list LEFT JOIN applications ON payment_list.mzuid=applications.mzuid";
            } else if (request()->filter == 'nopair') {
                $sql = "SELECT payment_list.id,payment_list.name, payment_list.amount, payment_list.course, applications.name as appl_name, payment_list.application_id
                    FROM payment_list LEFT JOIN applications ON payment_list.mzuid=applications.mzuid
                    WHERE applications.id is NULL";
            } else if (request()->filter == 'nolink') {
                $sql = "SELECT payment_list.id,payment_list.name, payment_list.amount, payment_list.course, applications.name as appl_name, payment_list.application_id
                    FROM payment_list LEFT JOIN applications ON payment_list.mzuid=applications.mzuid
                    WHERE payment_list.application_id = 0";
            } else {
                $sql = "SELECT payment_list.id,payment_list.name, payment_list.amount, payment_list.course, applications.name as appl_name, payment_list.application_id
                    FROM payment_list LEFT JOIN applications ON payment_list.mzuid=applications.mzuid";
            }
        } else {
            $sql = "SELECT payment_list.id,payment_list.name, payment_list.amount, payment_list.course, applications.name as appl_name, payment_list.application_id
                    FROM payment_list LEFT JOIN applications ON payment_list.mzuid=applications.mzuid";
        }
        $results = DB::select($sql);
        // return Payment::all();
        // $sql = "SELECT payment_list.name, payment_list.amount, payment_list.course, applications.name as appl_name
        //     FROM payment_list LEFT JOIN applications ON payment_list.mzuid=applications.mzuid";

        return view('bulk_update.index', ['results' => $results]);
    }

    public function show($id)
    {
        $payment = Payment::find($id);
        // $admission = $payment->admission();
        // return [
        //     'payment' => $payment,
        //     'application' => $payment->application(),
        //     'admission' => $admission
        // ];
        return view('bulk_update.show', ['payment' => $payment]);
    }

    public function link()
    {
        // return request()->payment_id;
        $payment = Payment::find(request()->payment_id);
        // return request();
        if (request()->has('application_id')) {
            $payment->update([
                'application_id' => request()->application_id
            ]);
            return $payment;
        } else if ($payment && $payment->appl_mzuid()) {

            $payment->update([
                'application_id' => $payment->appl_mzuid()->id
            ]);
            return $payment;
        } else {
            return "Incorrect";
        }
    }

    public function admissionUpdate()
    {
        // return request()->payment_id;
        $payment = Payment::find(request()->payment_id);
        if ($payment && $payment->allotment()) {
            $allotment = $payment->allotment();
            // return $allotment;
            $admission = Admission::updateOrCreate([
                'allotment_id' => $allotment->id,
                'sessn_id' => $payment->sessn_id,
            ], [
                'allotment_id' => $allotment->id,
                'sessn_id' => $payment->sessn_id,
                'allot_hostel_id' => $allotment->valid_allot_hostel() ? $allotment->valid_allot_hostel()->id : 0,
                'detail' => 'New admission payment',
                'ref' => $payment->voucher,
                'amount' => $payment->amount,
                'updated_by' => '3',
                'verified' => 1,
                'verified_by' => 3,
                'payment_dt' => '2026-08-07 00:00:00',
            ]);

            return $admission;
        } else {
            return "Incorrect";
        }
    }

    public function search($id)
    {
        $payment = Payment::find($id);
        $data = [
            'payment' => $payment,
            'applications' => Application::where('course_id', $payment->course_id)->where('status', 'Notified')->orderBy('name')->get()
        ];


        return view('bulk_update.search', $data);
        // return $mates;
    }

    public function bulkUpdate()
    {
        $payments = Payment::where('application_id', '<>', 0)->get();
        foreach ($payments as $payment) {
            $allotment = $payment->allotment();
            $application = $payment->application();
            if ($allotment) {
                $admission = Admission::updateOrCreate([
                    'allotment_id' => $allotment->id,
                    'sessn_id' => $payment->sessn_id,
                ], [
                    'allotment_id' => $allotment->id,
                    'sessn_id' => $payment->sessn_id,
                    'allot_hostel_id' => $allotment->valid_allot_hostel() ? $allotment->valid_allot_hostel()->id : 0,
                    'detail' => 'New admission payment',
                    'ref' => $payment->voucher,
                    'amount' => $payment->amount,
                    'updated_by' => '3',
                    'verified' => 1,
                    'verified_by' => 3,
                    'payment_dt' => '2026-08-07 00:00:00',
                ]);
                if ($application && $application->valid) {
                    $allotment->update([
                        'confirmed' => 1,
                        'admitted' => 1,
                        'valid' => 1
                    ]);
                } else {
                    $allotment->update([
                        'confirmed' => 0,
                        'admitted' => 1,
                        'valid' => 0
                    ]);
                }
            }
        }
        return redirect('/bulkupdate')
            ->with(['message' => ['type' => 'info', 'text' => 'Successful']]);
    }
}
