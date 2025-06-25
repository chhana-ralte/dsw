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

    public function manages(User $user): bool
    {
        return $user->isAdmin() || $user->isDsw();
    }
}
