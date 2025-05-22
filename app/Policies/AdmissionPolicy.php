<?php

namespace App\Policies;

use App\Models\User;

class AdmissionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Admission $admission){
        if($user->isAdmin() || $user->isDsw()){
            return true;
        }
        else if($user->isWarden()){
            return true;
        }
        else if($user->isPrefectOf($hostel->id) || $user->isMessSecretaryOf($hostel->id)){
            return true;
        }
        else{
            return false;
        }
    }

    public function manage(User $user, Admission $admission){

        if($user->isAdmin() || $user->isDsw()){
            return true;
        }
        else if($user->isWarden()){
            return true;
        }
        else if($user->isPrefectOf($hostel->id) || $user->isMessSecretaryOf($hostel->id)){
            return true;
        }
        else{
            return false;
        }
    }
}
