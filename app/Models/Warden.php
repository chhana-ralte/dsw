<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warden extends Model
{
    protected $guarded = [];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function user()
    {
        if ($this->valid) {
            $role_user = Role_User::where('type', 'warden')->where('foreign_id', $this->id)->first();
            if ($role_user) {
                return User::findOrFail($role_user->user_id);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
