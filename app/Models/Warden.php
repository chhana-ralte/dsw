<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warden extends Model
{
    protected $guarded = [];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
