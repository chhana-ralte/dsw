<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allotment extends Model
{
    protected $guarded = [];

    public function notification(){
        return $this->belongsTo(Notification::class);
    }

    public function hostel(){
        return $this->belongsTo(Hostel::class);
    }

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function allot_hostels(){
        return $this->hasMany(AllotHostel::class);
    }

    public function allot_hostel(){
        return AllotHostel::where('allotment_id',$this->id)->first();
    }

    public function valid_allot_hostel(){
        return AllotHostel::where('allotment_id',$this->id)->where('valid',1)->first();
    }

    public function admissions(){
        return $this->hasMany(Admission::class);
    }

    public function admission($sessn_id){
        return Admission::where('sessn_id',$sessn_id)->where('allotment_id',$this->id)->first();
    }

    public function cancel_seat(){
        return $this->hasOne(CancelSeat::class);
    }
}
