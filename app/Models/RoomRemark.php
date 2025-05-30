<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomRemark extends Model
{
    public $guarded = [];

    public function room(){
        return $this->belongsTo(Room::class);
    }
}
