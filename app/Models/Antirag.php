<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antirag extends Model
{
    protected $guarded = [];

    public function allotment()
    {
        return $this->belongsTo(Allotment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
