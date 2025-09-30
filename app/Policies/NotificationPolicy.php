<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NotiMaster;
use App\Models\Notification;

class NotificationPolicy
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
        return $user->isDsw() || $user->isAdmin();
    }


    public function views(User $user)
    {
        return $user->max_role_level() >= 3;
    }

    public function view_noti(User $user)
    {
        return true;
    }
}
