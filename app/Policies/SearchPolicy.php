<?php

namespace App\Policies;

use App\Models\User;

class SearchPolicy
{
    public function search(User $user): bool
    {
        return $user->max_role_level() >= 2;
    }
}
