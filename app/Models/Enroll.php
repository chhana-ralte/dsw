<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function std()
    {
        return $this->belongsTo(Std::class);
    }

    public function sessn()
    {
        return $this->belongsTo(Sessn::class);
    }
}
