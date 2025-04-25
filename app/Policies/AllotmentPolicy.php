<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Allotment;

class AllotmentPolicy
{
    public function view(User $user, Allotment $allotment): bool
    {
        // return false;
        if ($user->level >= 3) {
            return true;
        } else if ($user->allotment() && $user->allotment()->id == $allotment->id) {
            return true;
        } else {
            return false;
        }
    }
}
