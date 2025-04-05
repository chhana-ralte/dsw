<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    public $guarded = [];

    public function person(){
        return $this->belongsTo(Person::class);
    }
    
}
