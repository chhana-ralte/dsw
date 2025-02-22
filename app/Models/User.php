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
        'teacher_id'
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

    public function department(){
        if($this->department_id){
            return Department::find($this->department_id);
        }
        else{
            return false;
        }
    }

    public function teacher(){
        if($this->teacher_id){
            return Teacher::find($this->teacher_id);
        }
        else{
            return false;
        }
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($strrole):bool
    {
        $role = Role::where('role',$strrole)->first();
        return Role_User::where('user_id',$this->id)->where('role_id',$role->id)->exists();
        //return User::where('role', $role->role)->get();
    }

    public function attmasters(){
        return $this->hasMany(Attmaster::class);
    }

}
