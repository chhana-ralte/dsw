<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonRemarkDetail extends Model
{
    protected $guarded = [];

    public function person_remark(){
        return $this->belongsTo(PersonRemark::class);
    }
}
