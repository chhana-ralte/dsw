<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackString extends Model
{
    protected $guarded = [];

    public function feedback_detail()
    {
        return $this->belongsTo(FeedbackDetail::class);
    }
}
