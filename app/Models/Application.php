<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = [];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
