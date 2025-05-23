<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FeedbackCriteria;
use App\Models\FeedbackOption;

class FeedbackOptionController extends Controller
{
    public function store(FeedbackCriteria $feedbackCriterion)
    {
        // return $feedbackCriterion;
        request()->validate([
            'option' => 'required',
            'serial' => 'required',
        ]);

        $feedbackOption = FeedbackOption::create([
            'feedback_criteria_id' => $feedbackCriterion->id,
            'option' => request()->option,
            'serial' => request()->serial,
        ]);
        return redirect('/feedbackCriteria/' . $feedbackCriterion->id)->with(['message' => ['type' => 'info', 'text' => 'New feedback option created']]);
    }
}
