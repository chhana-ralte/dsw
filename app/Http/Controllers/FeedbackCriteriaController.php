<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FeedbackMaster;
use App\Models\FeedbackCriteria;
use App\Notifications\Feedback;

class FeedbackCriteriaController extends Controller
{
    public function index(FeedbackMaster $feedbackMaster)
    {
        $data = [
            'feedback_master' => $feedbackMaster,
            'feedback_criterias' => \App\Models\FeedbackCriteria::where('feedback_master_id', $feedbackMaster->id)->orderBy('serial')->get(),
        ];
        return view('feedbackCriteria.index', $data);
    }

    public function create(FeedbackMaster $feedbackMaster)
    {
        $data = [
            'feedback_master' => $feedbackMaster
        ];
        return view('feedbackCriteria.create', $data);
    }

    public function store(FeedbackMaster $feedbackMaster)
    {
        request()->validate([
            'criteria' => 'required',
            'type' => 'required',
        ]);


        $feedbackCriteria = FeedbackCriteria::create([
            'feedback_master_id' => $feedbackMaster->id,
            'criteria' => request()->criteria,
            'type' => request()->type,
        ]);
        if (request()->serial == null) {
            $max_serial = FeedbackCriteria::where('feedback_master_id', $feedbackMaster->id)->max('serial');
            $feedbackCriteria->update(['serial' => $max_serial + 1]);
        } else {
            FeedbackCriteria::where('feedback_master_id', $feedbackMaster->id)->where('serial', '>', request()->serial)->update(['serial' => request()->serial + 1]);
            $feedbackCriteria->update(['serial' => request()->serial]);
        }

        return redirect('/feedbackMaster/' . $feedbackMaster->id . '/criteria')->with(['message' => ['type' => 'info', 'text' => 'New feedback criteria created']]);
    }
}
