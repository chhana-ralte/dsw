<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filelink extends Model
{
    protected $guarded = [];

    public function file(){
        return $this->belongsTo(File::class);
    }

    public function sop(){
        return $this->belongsTo(Sop::class);
    }

}
