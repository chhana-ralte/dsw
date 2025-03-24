<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public $guarded = [];

    public function students(){
        return $this->hasMany(App\Models\Student::class);
    }

    public function student(){
        return Student::where('person_id',$this->id)->first();
    }

    public function others(){
        return Other::where('person_id',$this->id)->get;
    }
    
    public function other(){
        return Other::where('person_id',$this->id)->first();
    }
}
