<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NotiMaster;

class NotiMasterPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, NotiMaster $noti_master)
    {
        if ($noti_master->type == 'notification') {
            return true;
        } else {
            return $user->max_role_level() >= 3;
        }
    }
}
