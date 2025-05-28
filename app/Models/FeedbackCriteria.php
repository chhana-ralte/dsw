<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackCriteria extends Model
{
    protected $guarded = [];

    public function feedback_options()
    {
        return $this->hasMany(FeedbackOption::class);
    }

    public function feedback_master()
    {
        return $this->belongsTo(FeedbackMaster::class);
    }

    public function strings(){ // For string feedback
        $feedback_details = FeedbackDetail::where('feedback_criteria_id',$this->id);
        $feedback_strings = FeedbackString::whereIn('feedback_detail_id',$feedback_details->pluck('id'));
        return $feedback_strings->get();
    }

    public function average(){ // for rating feedback
        return FeedbackDetail::where('feedback_criteria_id',$this->id)->average('value');
    }

    public function options(){
        $options = FeedbackOption::where('feedback_criteria_id',$this->id);
    }
}
