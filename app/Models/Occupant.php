<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupant extends Model
{
    protected $table = null;
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function allot_seat()
    {
        return $this->belongsTo(AllotSeat::class);
    }

    public function allot_hostel()
    {
        return $this->belongsTo(AllotHostel::class);
    }

    public function allotment()
    {
        return $this->belongsTo(Allotment::class);
    }

    public function cancel_seat()
    {
        return $this->belongsTo(CancelSeat::class);
    }

    public function sessn()
    {
        return $this->belongsTo(Sessn::class);
    }
}
