<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $guarded = [];

    public function feedback_master(){
        return $this->belongsTo(FeedbackMaster::class);
    }

    
}
