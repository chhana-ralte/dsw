<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackCriteria extends Model
{
    protected $guarded = [];

    public function options()
    {
        return $this->hasMany(FeedbackOption::class);
    }

    public function feedback_master()
    {
        return $this->belongsTo(FeedbackMaster::class);
    }
}
