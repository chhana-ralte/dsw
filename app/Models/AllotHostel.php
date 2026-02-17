<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllotHostel extends Model
{
    public $guarded = [];

    public function allotment()
    {
        return $this->belongsTo(Allotment::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function allot_seats()
    {
        return $this->hasMany(AllotSeat::class);
    }

    public function allot_seat()
    {
        return AllotSeat::where('allot_hostel_id', $this->id)->orderBy('id', 'desc')->first();
    }

    public function valid_allot_seat()
    {
        return AllotSeat::where('allot_hostel_id', $this->id)->where('valid', 1)->first();
    }

    public function admission($sessn_id)
    {
        return Admission::where('sessn_id', $sessn_id)->where('allot_hostel_id', $this->id)->first();
    }

    public function semfees(){
        return $this->hasMany(Semfee::class);
    }

    public function semfee(){

    }
}
