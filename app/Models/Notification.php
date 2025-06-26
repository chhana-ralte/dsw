<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];

    public function allotments(){
        return $this->hasMany(Allotment::class);
    }

    public function sem_allots(){
        return $this->hasMany(SemAllot::class);
    }
}
