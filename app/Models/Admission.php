<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $guarded = [];

    public function sessn()
    {
        return $this->belongsTo(Sessn::class);
    }

    public function allotment()
    {
        return $this->belongsTo(Allotment::class);
    }
    public function allot_hostel()
    {
        return $this->belongsTo(AllotHostel::class);
    }
}
