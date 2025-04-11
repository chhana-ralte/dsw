<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonRemark extends Model
{
    protected $guarded = [];

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function person_remark_details(){
        return $this->hasMany(PersonRemarkDetail::class);
    }
}
