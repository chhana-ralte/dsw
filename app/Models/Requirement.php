<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $guarded = [];

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function allotment(){
        return $this->belongsTo(Allotment::class);
    }

    public function allot_hostel(){
        return $this->belongsTo(AllotHostel::class);
    }

    public function for_sessn(){
        return Sessn::where('id',$this->for_sessn_id)->first();
    }
    public function hostel(){
        return $this->belongsTo(Hostel::class);
    }
}
