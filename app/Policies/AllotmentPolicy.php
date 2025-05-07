<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Allotment;

class AllotmentPolicy
{
    public function view(User $user, Allotment $allotment): bool
    {
        // return false;
        if ($user->max_role_level() >= 3) {
            return true;
        } else if ($user->allotment() && $user->allotment()->id == $allotment->id) {
            return true;
        } else {
            return false;
        }
    }

    public function edit(User $user, Allotment $allotment): bool
    {
        // return false;
        if ($user->max_role_level() >= 4) { // DSW
            return true;
        } else if ($allotment->valid_allot_hostel() && $user->isWardenOf($allotment->valid_allot_hostel()->hostel->id)) { //Concerned Warden
            return true;
        } else {
            return false;
        }
    }

    public function manage(User $user, Allotment $allotment): bool
    {
        if ($user->max_role_level() >= 4) { // DSW
            return true;
        } else if ($allotment->valid_allot_hostel() && $user->isWardenOf($allotment->valid_allot_hostel()->hostel->id)) { //Concerned Warden
            return true;
        } else {
            return false;
        }
    }

    public function manage_self(User $user, Allotment $allotment): bool
    {
        if ($user->max_role_level() >= 3) {
            return true;
        } else if ($user->allotment() && $user->allotment()->id == $allotment->id) {
            return true;
        } else {
            return false;
        }
    }
}
