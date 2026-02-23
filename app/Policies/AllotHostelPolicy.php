<?php

namespace App\Policies;

use App\Models\AllotHostel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AllotHostelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    public function manage_semfee(User $user, AllotHostel $allot_hostel){
        if($user->max_role_level() > 3){
            return true;
        }
        else if($user->isWardenOf($allot_hostel->hostel_id)){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AllotHostel $allotHostel): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AllotHostel $allotHostel): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AllotHostel $allotHostel): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AllotHostel $allotHostel): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AllotHostel $allotHostel): bool
    {
        //
    }
}
