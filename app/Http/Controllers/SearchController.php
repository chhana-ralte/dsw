<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
// use App\Models\Student;
use App\Models\Hostel;


class SearchController extends Controller
{
    public function index(){
        if(isset(request()->str)){
            $students = \App\Models\Student::whereLike('rollno','%' . request()->str . '%')
                ->orWhereLike('course','%' . request()->str . '%')
                ->orWhereLike('department','%' . request()->str . '%')->get();
            
            $persons = Person::whereHas('students',function($query) use ($students){
                    $query->whereIn('person_id',$students->pluck('person_id'));
                })->orWhereLike('name','%' . request()->str . '%')->get();

            $data = [
                'persons' => $persons,
                'str' => request()->str
            ];
        }
        else{
            $data = [
                'persons' => [],
                'str' => ''
            ];
            
        }
        return view('search',$data);
    }
}
