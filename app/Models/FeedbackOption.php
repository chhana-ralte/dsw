<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackOption extends Model
{
    protected $guarded = [];

    public function feedback_criteria(){
        return $this->belongsTo(FeedbackCriteria::class);
    }

    public function no_of_count(){

        return FeedbackDetail::where('feedback_criteria_id',$this->feedback_criteria->id)->where('value',$this->id)->count();
    }

}
