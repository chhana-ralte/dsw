<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $guarded = [];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function allotment()
    {
        return $this->belongsTo(Allotment::class);
    }

    public function allot_hostel()
    {
        return $this->belongsTo(AllotHostel::class);
    }

    public function for_sessn()
    {
        return Sessn::where('id', $this->for_sessn_id)->first();
    }
    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }
    public function new_hostel()
    {
        return $this->belongsTo(Hostel::class, 'new_hostel_id');
    }

    public function roomType()
    {
        return $this->roomcapacity == 1 ? 'Single' : ($this->roomcapacity == 2 ? 'Double' : ($this->roomcapacity == '3' ? 'Triple' : 'Dormitory'));
    }
    public function new_roomType()
    {
        return $this->new_roomcapacity == 1 ? 'Single' : ($this->new_roomcapacity == 2 ? 'Double' : ($this->new_roomcapacity == '3' ? 'Triple' : 'Dormitory'));
    }

    public static function nothing($hostel_id = 0)
    {
        if ($hostel_id == 0) {
            return AllotHostel::where('valid',1)->whereNotIn('id',Requirement::all()->pluck('allot_hostel_id'));
        } else {
            return AllotHostel::where('hostel_id',$hostel_id)->where('valid',1)->whereNotIn('id',Requirement::all()->pluck('allot_hostel_id'));
        }
    }
    public static function applied($hostel_id = 0)
    {
        if ($hostel_id == 0) {
            return Requirement::where('new_hostel_id', '0');
        } else {
            // $allot_hostels = AllotHostel::where('hostel_id', $hostel_id)->where('valid', 1);
            return Requirement::where('hostel_id', $hostel_id)->where('new_hostel_id', '0');
        }
    }

    public static function resolved($hostel_id = 0)
    {
        if ($hostel_id == 0) {
            return Requirement::where('new_hostel_id', '<>', '0')->where('notified', '0');
        } else {
            return Requirement::where('new_hostel_id', $hostel_id)->where('notified', '0');
        }
    }

    public static function notified($hostel_id = 0)
    {
        if ($hostel_id == 0) {
            return Requirement::where('new_hostel_id', '<>', '0')->where('notified', '1');
        } else {
            return Requirement::where('new_hostel_id', $hostel_id)->where('notified', '1');
        }
    }

    public function sem_allot()
    {
        return SemAllot::where('requirement_id', $this->id)->first();
    }

    public function valid_sem_allot()
    {
        return SemAllot::where('requirement_id', $this->id)->where('valid', 1)->get();
    }
}
