<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackMaster extends Model
{
    protected $guarded = [];

    public function feedback_criteria()
    {
        return $this->hasMany(FeedbackCriteria::class);
    }
}
