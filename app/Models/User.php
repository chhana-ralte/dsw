<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'department_id',
        'teacher_id',
        'person_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function user_roles()
    {
        return Role_User::where('user_id', $this->id)->get();
    }

    public function max_role_level()
    {
        return $this->roles->max('level');
    }

    public function isWardenOf($hostel_id)
    {
        $role = Role::where('role', 'Warden')->first();
        if (Role_User::where('user_id', $this->id)->where('role_id', $role->id)->where('type', 'hostel')->where('foreign_id', $hostel_id)->exists()) {
            return true;
        } else {
            $warden = Warden::where('hostel_id', $hostel_id)->where('valid', 1)->first();
            if($warden){
                return Role_User::where('user_id', $this->id)->where('role_id', $role->id)->where('type', 'warden')->where('foreign_id', $warden->id)->exists();
            }
            else{
                return false;
            }

        }
    }

    public function isWardensOf()
    {
        $role_users = Role_User::where('type', 'warden')->where('user_id',$this->id);
        $wardens = Warden::whereIn('id',$role_users->pluck('foreign_id'));
        return Hostel::whereIn('id',$wardens->pluck('hostel_id'))->get();
        return ['hostels' => Hostel::whereIn('id',$wardens->pluck('hostel_id'))->get()];
    }

    public function isPrefectOf($hostel_id)
    {
        $role = Role::where('role', 'Prefect')->first();
        if (Role_User::where('user_id', $this->id)->where('role_id', $role->id)->where('type', 'hostel')->where('foreign_id', $hostel_id)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    public function isMessSecretaryOf($hostel_id)
    {
        $role = Role::where('role', 'Mess Secretary')->first();
        if (Role_User::where('user_id', $this->id)->where('role_id', $role->id)->where('type', 'hostel')->where('foreign_id', $hostel_id)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    public function isWarden()
    {
        $role = Role::where('role', 'Warden')->first();
        return Role_User::where('user_id', $this->id)->where('role_id', $role->id)->exists();
    }

    public function wardens()
    {
        $role = Role::where('role', 'Warden')->first();
        $role_users = Role_User::where('role_id', $role->id)->where('user_id', $this->id)->where('type', 'warden')->get();
        $wardens = Warden::whereIn('id', $role_users->pluck('foreign_id'));
        return $wardens->get();
    }

    public function isAdmin()
    {
        $role = Role::where('role', 'Admin')->first();
        return Role_User::where('user_id', $this->id)->where('role_id', $role->id)->exists();
    }


    public function isDsw()
    {
        $role = Role::where('role', 'DSW')->first();
        return Role_User::where('user_id', $this->id)->where('role_id', $role->id)->exists();
    }

    public function isInmate()
    {
        $role = Role::where('role', 'Inmate')->first();
        return Role_User::where('user_id', $this->id)->where('role_id', $role->id)->exists();
    }

    public function allotment()
    {
        $role = Role::where('role', 'Inmate')->first();
        if (!$role) {
            $role = Role::create(['role' => 'Inmate', 'level' => 1]);
        }
        $role_user = Role_User::where('user_id', $this->id)
            ->where('type', 'allotment')
            ->where('role_id', $role->id)
            ->first();

        if ($role_user) {
            return Allotment::findOrFail($role_user->foreign_id);
        } else {
            return false;
        }
    }

    public function hasRole($strRole)
    {
        $role = Role::where('role', $strRole)->first();
        return Role_User::where('user_id', $this->id)->where('role_id', $role->id)->exists();
    }

    public function hasWardenRole($hostel_id)
    {
        // return $hostel_id;
        $role = Role::where('role', 'Warden')->first();
        // return $role;
        return Role_User::where('user_id', $this->id)->where('role_id', $role->id)->where('type', 'hostel')->where('foreign_id', $hostel_id)->exists();
    }
}
