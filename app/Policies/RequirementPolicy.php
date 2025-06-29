<?php

namespace App\Policies;

use App\Models\User;

class RequirementPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function viewList(User $user): bool{
        return true;
        return $user->max_role_level() >= 2;
    }

    public function view(User $user, Requirement $requirement){
        if ($user->max_role_level() >= 2){
            return true;
        }
        if($user->allotment() && $user->allotment()->id == $requirement->allot_hostel->allotment->id){
            return true;
        }
    }

    public function manage(User $user, Requirement $requirement){
        return $user->isAdmin() || $user->isDsw();
    }

    public function manages(User $user): bool
    {
        return $user->isAdmin() || $user->isDsw();
    }
}
