<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clearance extends Model
{
    protected $guarded = [];
    public function cancel_seat()
    {
        return $this->belongsTo(CancelSeat::class);
    }
}
