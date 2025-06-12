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
use App\Models\Warden;
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
            $role_users = Role_User::where('user_id', auth()->user()->id)->where('type', 'warden');
            $wardens = Warden::where('valid', 1)->whereIn('id', $role_users->pluck('foreign_id'));
            $hostels = Hostel::whereIn('id', $wardens->pluck('hostel_id'));

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
        if (isset(request()->type) && isset(request()->id)) {
            if (request()->type == 'warden') {
                $warden = Warden::findOrFail(request()->id);
                $person = $warden->person;
                $data = [
                    'type' => request()->type,
                    'id' => request()->id,
                    'person' => $person,
                    'warden' => $warden,
                ];
            } else if (request()->type == 'allotment') {
                $allotment = Allotment::findOrFail(request()->id);
                $person = $allotment->person;
                $data = [
                    'type' => request()->type,
                    'id' => request()->id,
                    'person' => $person,
                    'allotment' => $allotment,
                ];
            }
        } else {
            $data = ['type' => '', 'id' => ''];
        }
        return view('user.create', $data);

        abort(403);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'username' => 'required|min:5',
            'password' => 'required|min:6|confirmed'
        ]);

        if (User::where('username', request()->username)->exists()) {
            return redirect()->back()->withErrors(['username' => 'Username already exists'])->withInput();
        }

        $user = User::create([
            'name' => request()->name,
            'username' => request()->username,
            'password' => Hash::make(request()->password),
        ]);

        // $role_user = Role_User::create([
        //     'user_id' => $user->id,
        //     'role_id' => Role::where('role', request()->type)->first()->id,
        //     'type' => request()->type,
        //     'foreign_id' => request()->id,
        // ]);

        return redirect('/user')->with(['message' => ['type' => 'info', 'text' => 'User created']]);
    }

    public function edit(User $user)
    {
        // return $user->hasRole('Admin');
        // return $role->id;
        $role = Role::where('role', 'Warden')->first();
        $level = $role->level;
        if (auth()->user()->max_role_level() >= $level || auth()->user()->isAdmin()) {
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
        if (request()->password) {
            request()->validate([
                'name' => 'required|min:6',
                'username' => 'required|min:5',
                'password' => 'required|min:6',
            ]);
            $password = Hash::make(request()->password);
        } else {
            request()->validate([
                'name' => 'required|min:6',
                'username' => 'required|min:5',
            ]);
            $password = $user->password;
        }

        if (User::where('username', request()->username)->whereNot('id', $user->id)->exists()) {
            return redirect()->back()->withErrors(['username' => 'Username already exists'])->withInput();
        }

        if (request()->roles) {
            $user->update([
                'name' => request()->name,
                'username' => request()->username,
                'password' => $password,
            ]);
            $roles = Role::whereIn('id', request()->roles)->get();
            $inmate_role = Role::where('role', 'Inmate')->first();
            // return $roles;

            Role_User::where('user_id', $user->id)->where('role_id', '<>', $inmate_role->id)
                ->whereNotIn('role_id', request()->roles)
                ->delete();
            foreach (request()->roles as $role_id) {
                $role = Role::find($role_id);
                if ($role->role == 'Warden') {
                    $wardens = Warden::whereIn('hostel_id', request()->hostel);
                    Role_User::where('user_id', $user->id)->where('role_id', $role->id)->where('type', 'warden')->whereNotIn('foreign_id', $wardens->pluck('id'))->delete();
                    foreach (request()->hostel as $hostel_id) {
                        $person = \App\Models\Person::updateOrCreate([
                            'name' => $user->name,
                        ], [
                            'name' => $user->name,
                        ]);

                        Warden::where('hostel_id', $hostel_id)->update([
                            'valid' => 0,
                        ]);

                        $warden = Warden::updateOrCreate([
                            'hostel_id' => $hostel_id,
                            'person_id' => $person->id,
                        ],[
                            'hostel_id' => $hostel_id,
                            'person_id' => $person->id,
                            'valid' => 1
                        ]);

                        Role_User::updateOrCreate(
                            [
                                'user_id' => $user->id,
                                'role_id' => $role->id,
                                'type' => 'warden',
                                'foreign_id' => $warden->id
                            ],
                            [
                                'user_id' => $user->id,
                                'role_id' => $role->id,
                                'type' => 'warden',
                                'foreign_id' => $warden->id
                            ]
                        );
                    }
                } else if ($role->level == 2) { // Prefect or mess secreatry
                    if (!isset(request()->hostel)) {
                        return redirect()->back()->withErrors(['selectHostel' => 'Please Select the Hostel']);
                        exit();
                    }
                    Role_User::where('user_id', $user->id)
                        ->where('role_id', $role->id)
                        ->where('type', 'hostel')
                        ->whereNotIn('foreign_id', request()->hostel)
                        ->delete();
                    foreach (request()->hostel as $hostel_id) {
                        Role_User::updateOrCreate([
                            'user_id' => $user->id,
                            'role_id' => $role->id,
                            'type' => 'hostel',
                            'foreign_id' => $hostel_id,
                        ], [
                            'user_id' => $user->id,
                            'role_id' => $role->id,
                            'type' => 'hostel',
                            'foreign_id' => $hostel_id,
                        ]);
                    }
                } else { // only user
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
        } else {
            return redirect()->back()->withErrors(['roles' => 'Select at least one role']);
        }
        // $user->roles()->sync(request()->roles);
        return redirect('/user')->with(['message' => ['type' => 'info', 'text' => 'User updated']]);
    }

    public function changePassword($user_id)
    {
        $user = User::findOrFail($user_id);
        if (auth() && auth()->user()->can('changePassword', $user)) {
            return view('user.changePassword', ['user' => $user]);
        } else {
            abort(403);
        }
    }

    public function changePasswordStore($user_id)
    {
        $user = User::findOrFail($user_id);
        request()->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        $user->update([
            'password' => Hash::make(request()->password)
        ]);
        return redirect('/user/' . $user->id . '/changePassword')->with(['message' => ['type' => 'info', 'text' => 'Password changed']]);
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
