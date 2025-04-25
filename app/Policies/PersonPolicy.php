<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Person;

class PersonPolicy
{
    public function edit(User $user, Person $person): bool
    {
        if ($user->allotment() && $user->allotment()->person->id == $person->id) {
            return true;
        } else if ($person->valid_allot_hostel() && $user->isWardenOf($person->valid_allot_hostel()->hostel->id)) {
            return true;
        } else if ($user->isDsw() || $user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }
}
