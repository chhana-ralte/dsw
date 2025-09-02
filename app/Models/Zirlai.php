<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zirlai extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function dikteis()
    {
        return $this->hasMany(Diktei::class);
    }

    public function dtallot()
    {
        return $this->hasOne(Dtallot::class);
    }
}
