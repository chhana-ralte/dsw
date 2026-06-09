<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function get_role(String $role_str)
    {
        return Role::where('role', $role_str)->first();
    }
}
