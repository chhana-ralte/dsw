<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Req extends Model
{
    protected $guarded = [];

    public function allot_hostel()
    {
        return $this->belongsTo(AllotHostel::class);
    }

    public function to_hostel()
    {
        return Hostel::where('id', $this->to_hostel_id)->first();
    }
    public function recommended1_by()
    {
        return User::findOrFail($this->recommended_by);
    }
    public function approved_by()
    {
        return User::findOrFail($this->approved_by);
    }
}
