<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllotHostel extends Model
{
    public $guarded = [];

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function hostel(){
        return $this->belongsTo(Hostel::class);
    }

    public function allot_seats(){
        return $this->hasMany(AllotSeat::class);
    }
    
}
