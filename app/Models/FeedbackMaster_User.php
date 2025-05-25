<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackMaster_User extends Model
{
    protected $guarded = [];
    protected $table = 'feedbackmaster_user';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function FeedbackMaster(){
        return $this->belongsTo(FeedbackMaster::class);
    }
}
