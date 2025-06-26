<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemAllot extends Model
{
    protected $guarded = [];
    public function requirement(){
        return $this->belongsTo(Requirement::class);
    }

    public function allotment(){
        return $this->belongsTo(Allotment::class);
    }

    public function sessn(){
        return $this->belongsTo(Sessn::class);
    }

    public function notification(){
        return $this->belongsTo(Notification::class);
    }
}
