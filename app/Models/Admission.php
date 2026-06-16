<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $guarded = [];

    public function sessn()
    {
        return $this->belongsTo(Sessn::class);
    }

    public function allotment()
    {
        return $this->belongsTo(Allotment::class);
    }

    public function allot_hostel()
    {
        return $this->belongsTo(AllotHostel::class);
    }

    public static function do_admission($request)
    {
        // return $request;
        $allotment = Allotment::findOrFail($request->allotment_id);
        if ($allotment->valid_allot_hostel()) {
            $allot_hostel = $allotment->valid_allot_hostel();
            if ($allotment->start_sessn_id == $request->sessn_id) {
                $detail = "New admission payment";
            } else {
                $detail = "Semester admission payment";
            }
            // return $request;

            $admission = Admission::create([
                    'allotment_id' => $allotment->id,
                    'sessn_id' => $request->sessn_id,
                    'ref' => $request->ref,
                    'allot_hostel_id' => $allot_hostel->id,
                    'amount' => $request->amount,
                    'payment_dt' => $request->payment_dt,
                    'detail' => $detail,
                    'updated_by' => auth()->user()->id,
                ]
            );

            if (auth()->user()->can('verify-admission', $allot_hostel->hostel)) {
                $admission->update([
                    'verified' => 1,
                    'verified_by' => auth()->user()->id,
                ]);
            }

            $allotment->update([
                'admitted' => 1,
                'confirmed' => 1,
                'valid' => 1,
            ]);

            $semfee = \App\Models\Semfee::where('allotment_id', $allotment->id)->where('sessn_id', $admission->sessn_id)->first();
            if ($semfee) {
                $semfee->update([
                    'status' => 'Paid'
                ]);
            }
            return (object)['status' => true, 'data' => ['admission' => $admission]];
        } else { // No valid hostel allotment
            return (object)['status' => false, 'data' => ['reason' => 'No valid allotment']];
        }
    }

    public function update_admission($request){
        $admission = Admission::findOrFail($request->admission_id);
        if(isset($request->sessn_id)){
            $admission->sessn_id = $request->sessn_id;
        }
        if(isset($request->amount)){
            $admission->amount = $request->amount;
        }
        if(isset($request->ref)){
            $admission->ref = $request->ref;
        }
        if(isset($request->payment_dt)){
            $admission->payment_dt = $request->payment_dt;
        }
        $admission->save();
    }

    public function remove_admission($request)
    {
        $admission = Admission::find($request->admission_id);
        $semfee = Semfee::where('allotment_id', $admission->allotment_id)->where('sessn_id', $admission->sessn_id)->first();
        if ($semfee && $semfee->status == 'Paid') {
            $semfee->update(['status' => 'Forwarded']);
        }
        $admission->delete();
        return $request->admission_id;
    }
}
