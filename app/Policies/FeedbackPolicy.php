<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class FeedbackPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function gives(User $user):bool
    {
        return $user->max_role_level() >= 3;

        $users = DB::select("SELECT users.*
            FROM users JOIN role_user ON users.id = role_user.user_id AND role_user.type = 'allotment'
            JOIN allotments ON allotments.id = role_user.foreign_id AND allotments.valid = 1
            WHERE users.id = " . $user->id );
        if(count($users) > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function manages(User $user):bool
    {
        return $user->max_role_level() >= 3;
    }
}
