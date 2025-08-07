<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];

    public function notiMaster()
    {
        return $this->belongsTo(NotiMaster::class);
    }

    public function allotments()
    {
        return $this->hasMany(Allotment::class);
    }

    public function sem_allots()
    {
        return $this->hasMany(SemAllot::class);
    }

    public function admissions($sessn_id = 0)
    {
        if ($this->type == 'allotment') {
            $admissions = Admission::join('allotments', 'admissions.allotment_id', '=', 'allotments.id')
                ->join('notifications', 'notifications.id', '=', 'allotments.notification_id')
                ->where('notifications.id', $this->id);
            if ($sessn_id > 0) {
                $admissions = $admissions->where('allotments.start_sessn_id', $sessn_id);
            }
            return $admissions->get();
        }
    }
}
