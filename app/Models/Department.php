<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->hasMany(Course::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    public function zirlais()
    {
        return $this->hasMany(Zirlai::class);
    }
}
