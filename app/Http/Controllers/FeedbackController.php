<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FeedbackMaster;
use App\Models\FeedbackCriteria;

class FeedbackController extends Controller
{
    public function index(FeedbackMaster $feedbackMaster)
    {
        $data = [
            'feedback_master' => $feedbackMaster,
        ];
        return view('feedback.index', $data);
    }

    public function create(FeedbackMaster $feedbackMaster)
    {
        $data = [
            'feedback_master' => $feedbackMaster,
            'feedback_criteria' => FeedbackCriteria::where('feedback_master_id', $feedbackMaster->id)->orderBy('serial')->get(),
        ];
        return view('feedback.create', $data);
    }

    public function store()
    {

        return request();
    }
}
