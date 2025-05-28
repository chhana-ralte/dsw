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

    public function report()
    {
        $no_of_feedbacks = Feedback::where('feedback_master_id', $this->id)->count();
        $no_of_users = FeedbackMaster_User::where('feedback_master_id', $this->id)->count();
        $no_of_criteria = FeedbackCriteria::where('feedback_master_id', $this->id)->count();
        $report = [
            'no_of_feedbacks' => $no_of_feedbacks,
            'no_of_users' => $no_of_users,
            'no_of_criteria' => $no_of_criteria,
        ];
        return $report;
    }
}
