<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    public $guarded = [];
    public function rooms(){
        return $this->hasMany(Room::class);
    }
}
