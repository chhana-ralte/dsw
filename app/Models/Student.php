<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $guarded = [];

    public function person(){
        return $this->belongsTo(App\Models\Person::class);
    }
}
