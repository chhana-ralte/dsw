<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $guarded = [];
    public function hostel(){
        return $this->belongsTo(Hostel::class);
    }

    public function seats(){
        return $this->hasMany(Seat::class);
    }
}
