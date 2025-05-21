<?php

namespace App\Policies;

use App\Models\Hostel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HostelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Hostel $hostel): bool
    {
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

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Hostel $hostel): bool
    {
        return $user->isWardenOf($hostel->id) || $user->isAdmin() || $user->isDsw();
    }

    public function manage(User $user, Hostel $hostel): bool
    {
        return $user->isWardenOf($hostel->id) || $user->isAdmin() || $user->isDsw();
    }

    public function delete(User $user, Hostel $hostel): bool
    {
        return $user->isAdmin() || $user->isDsw();
    }

    public function restore(User $user, Hostel $hostel): bool
    {
        //
    }

    public function forceDelete(User $user, Hostel $hostel): bool
    {
        //
    }
}
