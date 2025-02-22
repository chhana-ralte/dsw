<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllotSeat extends Model
{
    public $guarded = [];

    public function allot_hostel(){
        return $this->belongsTo(AllotHostel::class);
    }
}
