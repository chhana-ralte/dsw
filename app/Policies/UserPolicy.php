<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function manage(User $user, User $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        } else if ($user->isDsw() && !$model->isAdmin()) {
            return true;
        } else {
            if ($user->isWarden() && $model->allotment()) {
                if ($model->allotment()->valid_allot_hostel()) {
                    $hostel = $model->allotment()->valid_allot_hostel()->hostel;
                    if ($user->isWardenOf($hostel->id)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function changePassword(User $user, User $model): bool
    {
        if ($user->id == $model->id) {
            return true;
        } else {
            return $this->manage($user, $model);
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->max_role_level() >= 3;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return true;
    }
}
