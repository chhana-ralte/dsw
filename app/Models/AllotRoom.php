<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllotRoom extends Model
{
    public $guarded = [];

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function allot_hostel(){
        return $this->belongsTo(AllotHostel::class);
    }
}
