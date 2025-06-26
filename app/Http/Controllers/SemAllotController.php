<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Notification;
use App\Models\SemAllot;

class SemAllotController extends Controller
{
    public function index(Notification $notification){
        $sem_allots = SemAllot::where('notification_id', $notification->id)->orderBy('id')->get();
        $data = [
            'notification' => $notification,
            'sem_allots' => $sem_allots,
        ];
        return view('common.sem_allot.index',$data);
        return $notification;
    }
}
