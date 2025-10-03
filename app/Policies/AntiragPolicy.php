<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Antirag;

class AntiragPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function gives(User $user)
    {
        return $user->allotment();
    }

    public function given(User $user)
    {
        return $user->antirag();
    }
}
