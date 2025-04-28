<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Warden;

class WardenPolicy
{
    public function manage(User $user, Warden $warden): bool
    {
        if ($user->isAdmin() || $user->isDsw()) {
            return true;
        } else {
            return false;
        }
    }
}
