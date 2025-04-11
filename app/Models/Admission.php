<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $guarded = [];

    public function sessn(){
        return $this->belongsTo(Sessn::class);
    }
}
