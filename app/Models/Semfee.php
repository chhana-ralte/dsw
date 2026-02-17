<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semfee extends Model
{
    protected $guarded = [];

    public function allotment(){
        return $this->belongsTo(Allotment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sessn(){
        return $this->belongsTo(Sessn::class);
    }
}
