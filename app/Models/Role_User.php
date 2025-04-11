<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_User extends Model
{
    protected $guarded = [];
    protected $table = "role_user";
    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function hostel(){
        if($this->type == 'hostel'){
            return Hostel::findOrFail($this->foreign_id);
        }
    }
}
