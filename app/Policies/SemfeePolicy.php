<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Semfee;

class SemfeePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function manage(User $user, Semfee $semfee)
    {
        if ($user->max_role_level() > 3) {
            return true;
        } else if ($user->isWardenOf($semfee->allot_hostel->hostel_id)) {
            return true;
        } else {
            return false;
        }
    }

    public function update_payment(User $user, Semfee $semfee)
    {
        if ($user->isWardenOf($semfee->allot_hostel->hostel->id)) {
            return true;
        } else if ($user->isDsw()) {
            return true;
        } else if ($user->isFinance()) {
            return true;
        }
        return false;
    }
}
