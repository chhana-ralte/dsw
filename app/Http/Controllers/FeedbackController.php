<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FeedbackMaster;
use App\Models\FeedbackCriteria;
use App\Models\FeedbackDetail;
use App\Models\FeedbackString;
use App\Models\Feedback;
use App\Models\FeedbackMaster_User;

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

    public function store(FeedbackMaster $feedbackMaster, Request $request)
    {
        foreach ($request->request as $key => $val) {
            $arr = explode("_", $key);
            $feedback = Feedback::create([
                'feedback_master_id' => $feedbackMaster->id,
                'feedback_dt' => date('Y-m-d'),
                'done' => 0,
            ]);
            if ($arr[0] == 'criteria') {
                $criteria = FeedbackCriteria::find($arr[1]);
                if ($criteria->type == 'Rating' || $criteria->type == 'Multiple choice') {
                    FeedbackDetail::create([
                        'feedback_id' => $feedback->id,
                        'feedback_criteria_id' => $criteria->id,
                        'value' => $val,
                    ]);
                } else if ($criteria->type == 'Short answer') {
                    $feedback_detail = FeedbackDetail::create([
                        'feedback_id' => $feedback->id,
                        'feedback_criteria_id' => $criteria->id,
                        'value' => '0',
                    ]);
                    $feedback_string = FeedbackString::create([
                        'feedback_detail_id' => $feedback_detail->id,
                        'string' => $val,
                    ]);
                    $feedback_detail->update([
                        'value' => $feedback_string->id,
                    ]);
                } else {
                    abort(404);
                }
            }
        }
        $feedback->update([
            'done' => 1,
        ]);
        FeedbackMaster_User::updateOrCreate([
            'feedback_master_id' => $feedbackMaster->id,
            'user_id' => auth()->user()->id,
        ], [
            'feedback_master_id' => $feedbackMaster->id,
            'user_id' => auth()->user()->id,
            'feedback_dt' => date('Y-m-d'),
            'done' => 1,
        ]);
        return redirect("/feedbackMaster/" . $feedbackMaster->id . "/feedback")->with(['message' => ['type' => 'info', 'text' => 'Feedback completed']]);
    }

    public function report($feedback_master_id)
    {
        $feedback_master = FeedbackMaster::findOrFail($feedback_master_id);
        return $feedback_master;
        return $feedback_master;
    }
}
