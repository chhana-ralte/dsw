<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackDetail extends Model
{
    protected $guarded = [];

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }

    public function feedback_criteria(){
        return $this->belongsTo(FeedbackCriteria::class);
    }
}
