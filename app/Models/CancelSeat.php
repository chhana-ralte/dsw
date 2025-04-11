<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelSeat extends Model
{
    protected $guarded = [];

    public function allotment(){
        return $this->belongsTo(Allotment::class);
    }

    public function allot_hostel(){
        return $this->belongsTo(AllotHostel::class);
    }

    public function allot_seat(){
        return $this->belongsTo(AllotSeat::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
