<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allotment extends Model
{
    protected $guarded = [];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function allot_hostels()
    {
        return $this->hasMany(AllotHostel::class);
    }

    public function allot_hostel()
    {
        return AllotHostel::where('allotment_id', $this->id)->orderBy('id', 'desc')->first();
    }

    public function valid_allot_hostel()
    {
        return AllotHostel::where('allotment_id', $this->id)->where('valid', 1)->orderBy('id', 'desc')->first();
        //     ->withDefault([
        //     NoHostel::make(['id' => 0, 'hostel_id' => '0'])
        // ]);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function admission($sessn_id)
    {
        return Admission::where('sessn_id', $sessn_id)->where('allotment_id', $this->id)->first();
    }

    public function admission_any()
    {
        return Admission::where('allotment_id', $this->id)->first();
    }

    public function cancel_seat()
    {
        return $this->hasOne(CancelSeat::class);
    }

    public function user()
    {
        if (Role_User::where('type', 'allotment')->where('foreign_id', $this->id)->exists()) {
            $role_user = Role_User::where('type', 'allotment')->where('foreign_id', $this->id)->first();
            return User::where('id', $role_user->user_id)->first();
        } else {
            return false;
        }
    }

    public function start_sessn()
    {
        return Sessn::where('id', $this->start_sessn_id)->first();
    }

    public function end_sessn()
    {
        return Sessn::where('id', $this->end_sessn_id)->first();
    }

    public function requirements()
    {
        $allot_hostels = AllotHostel::where('allotment_id', $this->id);
        return Requirement::whereIn('allot_hostel_id', $allot_hostels->pluck('id'))->get();
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
