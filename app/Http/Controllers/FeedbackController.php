<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role_User;
use App\Models\User;
use App\Models\Allotment;
use App\Models\Warden;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback.index');
    }
    public function create()
    {
        return view('feedback.create');
    }

    public function store()
    {
        $role_users = Role_User::whereIn('type',['allotment','warden'])->get();
        // return $role_users;
        $str = "Start<br>";
        foreach($role_users as $ru){
            $user = User::find($ru->user_id);
            if($ru->type == 'allotment'){
                $allotment = Allotment::find($ru->foreign_id);
                User::where('id',$ru->user_id)->update([
                    'person_id' => $allotment->person->id,
                ]);
                $str .= "Updated user id: " . $user->id . " and allotment with person id :" . $allotment->person->id . " here<br>";
            }
            else{
                $warden = Warden::find($ru->foreign_id);
                User::where('id',$ru->user_id)->update([
                    'person_id' => $warden->person->id,
                ]);
                $str .= "Updated user id: " . $user->id . " and warden with person id :" . $warden->person->id . " here<br>";
            }
        }
        return $str;
        return request();
    }
}
