<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Role_User;
use App\Models\Allotment;
use App\Models\Hostel;
use App\Models\AllotHostel;

class UserController extends Controller
{
    public function index()
    {
        $role = Role::where('role', 'Warden')->first();
        $level = $role->level;
        // return $level;
        // return auth()->user()->max_role_level();
        if (auth()->user()->isDsw() || auth()->user()->isAdmin()) {
            $roles = Role::whereIn('role', ['DSW', 'Warden', 'Prefect', 'Mess Secretary']);
            $role_users = Role_User::whereIn('role_id', $roles->pluck('id'));
            $users = User::whereIn('id', $role_users->pluck('user_id'))->get();
        } else if (auth()->user()->isWarden()) {
            $role = Role::where('role', 'Warden');
            $role_users = Role_User::where('user_id', auth()->user()->id)->where('type', 'hostel');
            $hostels = Hostel::whereIn('id', $role_users->pluck('foreign_id'));

            $valid_allot_hostels = AllotHostel::where('valid', 1)->whereIn('hostel_id', $hostels->pluck('id'));

            $allotments = Allotment::whereIn('id', $valid_allot_hostels->pluck('allotment_id'));
            $role_users = Role_User::where('type', 'allotment')->whereIn('foreign_id', $allotments->pluck('id'));
            $users = User::whereIn('id', $role_users->pluck('user_id'))->get();
        } else {
            abort(403);
        }
        return view('user.index', ['users' => $users]);
    }

    public function show(User $user)
    {
        $role = Role::where('role', 'Warden')->first();
        $level = $role->level;
        if (auth()->user()->max_role_level() >= $level)
            return view('user.show', ['user' => $user]);
        else
            abort(403);
    }

    public function create()
    {
        $role = Role::where('role', 'Warden')->first();
        $level = $role->level;
        if (auth()->user()->max_role_level() >= $level) {
            if (isset(request()->type) && isset(request()->id)) {
                $data = [
                    'type' => request()->type,
                    'id' => request()->id,
                ];
            } else {
                $data = ['type' => '', 'id' => ''];
            }
            return view('user.create', $data);
        } else
            abort(403);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'username' => 'required',
        ]);
        if (User::where('username', request()->username)->exists()) {
            return redirect('/user/create')->with(['message' => ['type' => 'danger', 'text' => 'Username already taken']])->withInput();
        }
        return "hell";
        $user = User::create([
            'name' => request()->name,
            'username' => request()->username,
            'password' => Hash::make('password')
        ]);
        //$user->roles()->sync(request()->roles);
        return redirect('/user')->with(['message' => ['type' => 'info', 'text' => 'User created']]);
    }

    public function edit(User $user)
    {
        // return $user->hasRole('Admin');
        // return $role->id;
        $role = Role::where('role', 'Warden')->first();
        $level = $role->level;
        if (auth()->user()->max_role_level() >= $level) {
            $data = [
                'user' => $user,
                'roles' => Role::orderBy('level', 'desc')->get()
            ];
            return view('user.edit', $data);
        } else {
            abort(403);
        }
    }

    public function update(User $user)
    {
        // dd(request()->all());
        $user->update([
            'name' => request()->name,
            'username' => request()->username,
        ]);
        Role_User::where('user_id', $user->id)->whereNotIn('role_id', request()->roles)->delete();
        foreach (request()->roles as $role_id) {
            $role = Role::find($role_id);
            if ($role->role == 'Warden') {
                Role_User::where('user_id', $user->id)->where('role_id', $role->id)->where('type', 'hostel')->whereNotIn('foreign_id', request()->hostel)->delete();
                foreach (request()->hostel as $hostel_id) {
                    Role_User::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'role_id' => $role->id,
                            'type' => 'hostel',
                            'foreign_id' => $hostel_id
                        ],
                        [
                            'user_id' => $user->id,
                            'role_id' => $role->id,
                            'type' => 'hostel',
                            'foreign_id' => $hostel_id
                        ]
                    );
                }
            } else { // Not warden
                Role_User::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'role_id' => $role->id,
                    ],
                    [
                        'user_id' => $user->id,
                        'role_id' => $role->id,
                    ]
                );
            }
        }
        // $user->roles()->sync(request()->roles);
        return redirect('/user')->with(['message' => ['type' => 'info', 'text' => 'User updated']]);
    }

    public function changePassword()
    {
        $user = auth()->user();
        return view('user.changePassword', ['user' => $user]);
    }

    public function changePasswordStore()
    {
        $user = auth()->user();
        if (request()->password == request()->confirm_password) {
            $user->update([
                'password' => Hash::make(request()->password)
            ]);
            return redirect('/user/changePassword')->with(['message' => ['type' => 'info', 'text' => 'Password changed']]);
        } else {
            return redirect('/user/changePassword')->with(['message' => ['type' => 'danger', 'text' => 'Passwords do not match']])->withInput();
        }
    }

    public function destroy(User $user)
    {
        Role_User::where('user_id', $user->id)->delete();
        $user->delete();
        return redirect('/user')->with(['message' => ['type' => 'info', 'text' => 'User deleted']]);
        return $user->name;
    }

    public function login()
    {
        return view('user.login');
    }

    public function logincheck()
    {
        $login = Auth::attempt([
            'username' => request()->username,
            'password' => request()->password
        ]);
        if ($login) {
            request()->session()->regenerate();
            // if(auth()->user()->department_id){
            //     return redirect('/department/' . auth()->user()->department_id);
            // }
            // //return auth()->user()->name;
            // if(auth()->user()->name == 'Diktei'){
            //     return redirect('/diktei');
            // }
            return redirect('/');
        } else {
            return redirect('/login')->with(['message' => ['type' => 'danger', 'text' => 'Login Failed...']])->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with(['message' => ['type' => 'info', 'text' => 'Successfully logged out']]);
    }
}
