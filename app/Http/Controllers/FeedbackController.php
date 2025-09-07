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
        if(auth()->user() && auth()->user()->can('gives', App\Models\Feedback::class))
        {
            if(Feedback::where('user_id', auth()->user()->id)->exists()){
                return redirect()->back()->with(['message' => ['type' => 'warning', 'text' => 'Feedback already done.']]);
            }
            $data = [
                'feedback_master' => $feedbackMaster,
                'feedback_criteria' => FeedbackCriteria::where('feedback_master_id', $feedbackMaster->id)->orderBy('serial')->get(),
            ];
            return view('feedback.create', $data);
        }
        else{
            return redirect()->back()->with(['message' => ['type' => 'warning', 'text' => 'Unauthorised to give feedback']]);
        }
    }

    public function store(FeedbackMaster $feedbackMaster, Request $request)
    {
        // return $request;
        $feedback = Feedback::updateOrCreate([
            'feedback_master_id' => $feedbackMaster->id,
            'user_id' => auth()->user()->id,
        ]
        ,[
            'feedback_master_id' => $feedbackMaster->id,
            'user_id' => auth()->user()->id,
            'feedback_dt' => date('Y-m-d H:i:s'),
            'done' => 0,
        ]);
        foreach ($request->request as $key => $val) {
            $arr = explode("_", $key);

            if ($arr[0] == 'criteria') {
                $criteria = FeedbackCriteria::find($arr[1]);
                if ($criteria->type == 'Rating' || $criteria->type == 'Multiple choice') {
                    FeedbackDetail::updateOrCreate([
                        'feedback_id' => $feedback->id,
                        'feedback_criteria_id' => $criteria->id,
                    ],[
                        'feedback_id' => $feedback->id,
                        'feedback_criteria_id' => $criteria->id,
                        'value' => $val,
                    ]);
                } else if ($criteria->type == 'Short answer') {
                    $feedback_detail = FeedbackDetail::updateOrCreate([
                        'feedback_id' => $feedback->id,
                        'feedback_criteria_id' => $criteria->id,
                    ],[
                        'feedback_id' => $feedback->id,
                        'feedback_criteria_id' => $criteria->id,
                        'value' => '0',
                    ]);
                    $feedback_string = FeedbackString::updateOrCreate([
                        'feedback_detail_id' => $feedback_detail->id,
                    ],[
                        'feedback_detail_id' => $feedback_detail->id,
                        'string' => $val,
                    ]);
                    $feedback_detail->update([
                        'value' => $feedback_string->id,
                    ]);
                }
                else if ($criteria->type == 'Text') {
                    $feedback_detail = FeedbackDetail::updateOrCreate([
                        'feedback_id' => $feedback->id,
                        'feedback_criteria_id' => $criteria->id,
                    ],[
                        'feedback_id' => $feedback->id,
                        'feedback_criteria_id' => $criteria->id,
                        'value' => '0',
                    ]);
                    $feedback_string = FeedbackString::updateOrCreate([
                        'feedback_detail_id' => $feedback_detail->id,
                    ],[
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
        $feedback->save();

        FeedbackMaster_User::updateOrCreate([
            'feedback_master_id' => $feedbackMaster->id,
            'user_id' => auth()->user()->id,
        ], [
            'feedback_master_id' => $feedbackMaster->id,
            'user_id' => auth()->user()->id,
            'feedback_dt' => date('Y-m-d H:i:s'),
            'done' => 1,
        ]);
        return redirect("/")->with(['message' => ['type' => 'info', 'text' => 'Feedback completed']]);
    }

    public function action(){
        if(request()->action == 'open'){
            \App\Models\Manage::where('name','feedback')->update(['status'=>'open']);

        }
        else if(request()->action == 'close'){
            \App\Models\Manage::where('name','feedback')->update(['status'=>'closed']);

        }
        if(request()->action == 'clear'){
            \App\Models\FeedbackDetail::truncate();
            \App\Models\FeedbackString::truncate();
            \App\Models\FeedbackMaster_User::truncate();
            \App\Models\Feedback::truncate();

        }
        return redirect()->back()->with(['message' => ['type' => 'info', 'text' => 'Feedback updated successfully']]);
    }
}
