<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index(){
        return view('user.index',['users'=>User::all()]);
    }

    public function show(User $user){
        return view('user.show',['user'=>$user]);
    }

    public function create(){
        return view('user.create');
    }

    public function store(){
        request()->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => ['required','email']
        ]);
        $user = User::create([
            'name' => request()->name,
            'username' => request()->username,
            'email' => request()->email,
            'password' => Hash::make('password')
        ]);
        //$user->roles()->sync(request()->roles);
        return redirect('/user')->with(['message' => ['type'=>'info', 'text'=>'User created']]);
    }

    public function edit(User $user){
        $data=[
            'user' => $user,
            'roles' => Role::all()
        ];
        return view('user.edit',$data);
    }

    public function update(User $user){
        //dd(request()->all());
        $user->update([
            'name' => request()->name,
            'username' => request()->username,
            'email' =>request()->email
        ]);
        $user->roles()->sync(request()->roles);

        $dept_flag = 0;
        $teacher_flag = 0;
        foreach(request()->roles as $role_id){
            if(Role::find($role_id)->role == "Department"){
                $user->update([
                    'department_id' => request()->department
                ]);
                $dept_flag = 1;
            }
            if(Role::find($role_id)->role == "Teacher"){
                $user->update([
                    'teacher_id' => request()->teacher
                ]);
                $teacher_flag = 1;
            }
        }
        if($dept_flag == 0){
            $user->update([
                'department_id' => 0
            ]);
        }
        if($teacher_flag == 0){
            $user->update([
                'teacher_id' => 0
            ]);
        }
        return redirect('/user')->with(['message' => ['type'=>'info', 'text'=>'User updated']]);
    }

    public function changePassword(){
        $user = auth()->user();
        return view('user.changePassword',['user'=>$user]);
    }
    
    public function changePasswordStore(){
        $user = auth()->user();
        $user->update([
            'password' => Hash::make(request()->password)
        ]);
        return redirect('/user/changePassword')->with(['message' => ['type'=>'info', 'text'=>'Password changed']]);
    }

    public function destroy(User $user){
        $user->delete();
        return redirect('/user')->with(['message' => ['type'=>'info', 'text'=>'User deleted']]);
        return $user->name;
    }

    public function login(){
        return view('user.login');
    }

    public function logincheck(){
        $login = Auth::attempt([
            'username' => request()->username,
            'password' => request()->password
        ]);
        if($login){
            request()->session()->regenerate();
            if(auth()->user()->department_id){
                return redirect('/department/' . auth()->user()->department_id);
            }
            //return auth()->user()->name;
            if(auth()->user()->name == 'Diktei'){
                return redirect('/diktei');
            }
            return redirect('/');
        }
        else{
            return redirect('/login')->with(['message' => ['type'=>'danger','text'=>'Login Failed...']]);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    
}
