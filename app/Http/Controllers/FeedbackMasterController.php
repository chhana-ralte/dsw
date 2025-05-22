<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FeedbackMaster;

class FeedbackMasterController extends Controller
{
    public function index()
    {
        $data = [
            'feedback_masters' => FeedbackMaster::all()
        ];
        return view('feedbackMaster.index', $data);
    }

    public function create()
    {
        return view('feedbackMaster.create');
    }

    public function store()
    {
        request()->validate([
            'title' => 'required',
        ]);

        FeedbackMaster::create([
            'title' => request()->title,
            'remark' => request()->remark,
            'from_dt' => request()->from_dt,
            'to_dt' => request()->to_dt,
            'open' => request()->open ? '1' : '0',
        ]);
        return redirect('/feedbackMaster')->with(['message' => ['type' => 'info', 'text' => 'New feedback master created']]);
    }
    public function edit(FeedbackMaster $feedbackMaster)
    {
        $data = [
            'feedbackMaster' => $feedbackMaster
        ];
        return view('feedbackMaster.edit', $data);
    }

    public function show(FeedbackMaster $feedbackMaster)
    {
        $data = [
            'feedbackMaster' => $feedbackMaster
        ];
        return view('feedbackMaster.show', $data);
    }
    public function update(FeedbackMaster $feedbackMaster)
    {
        request()->validate([
            'title' => 'required',
        ]);

        $feedbackMaster->update([
            'title' => request()->title,
            'remark' => request()->remark,
            'from_dt' => request()->from_dt,
            'to_dt' => request()->to_dt,
            'open' => request()->open ? '1' : '0',
        ]);

        return redirect('/feedbackMaster/')->with(['message' => ['type' => 'info', 'text' => 'New feedback master updated']]);
    }
    public function destroy(FeedbackMaster $feedbackMaster)
    {
        // return "Hello";
        $feedbackMaster->delete();
        return redirect('/feedbackMaster/')->with(['message' => ['type' => 'info', 'text' => 'Feedback master deleted']]);
    }
}
