<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotiMaster extends Model
{
    protected $guarded = [];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
