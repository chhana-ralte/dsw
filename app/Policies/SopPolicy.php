<?php

namespace App\Policies;

use App\Models\User;

class SopPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function manages(User $user)
    {
        return $user->max_role_level() >= 3;
    }
}
