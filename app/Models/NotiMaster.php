<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotiMaster extends Model
{
    protected $guarded = [];
    private static $types = [
        'notification' => 'Notification',
        'allotment' => 'New allotments',
        'sem_allot' => 'Semester-wise allotments',
    ];

    public static function types()
    {
        return self::$types;
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function allotments()
    {
        return Allotment::whereIn('notification_id', $this->notifications->pluck('id'))
            ->orderBy('hostel_id')
            ->orderBy('sl')
            ->get();
    }
}
