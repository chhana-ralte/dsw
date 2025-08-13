<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diktei extends Model
{
    protected $guarded = [];

    public function zirlai(){
        return $this->belongsTo(Zirlai::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
