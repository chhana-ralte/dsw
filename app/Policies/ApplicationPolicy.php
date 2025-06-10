<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Application;

class ApplicationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Application $application): bool
    {
        return $user->max_role_level() >= 3;
    }

    public function viewlist(User $user, Application $application): bool
    {
        // return false;
        return auth()->user() && $user->max_role_level() >= 2;
    }

    public function manage(User $user, Application $application): bool
    {
        return $user->max_role_level() >= 3;
    }

    public function delete(User $user, Application $application): bool
    {
        return $user->isDsw() || $user->isAdmin();
    }
}
