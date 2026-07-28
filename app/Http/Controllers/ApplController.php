<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Person;
use App\Models\Student;
use App\Models\Application;


class ApplController extends Controller
{
    public function index()
    {
        $sql="SELECT state, count(if(gender='Male',1,NULL)) AS male, count(if(gender='Female',1,NULL)) AS female
            FROM applications GROUP BY state ORDER BY count(*) DESC";
        $states = DB::select($sql);
        $sql = "SELECT departments.id AS id, departments.name AS department, count(if(gender='Male',1,NULL)) AS male, count(if(gender='Female',1,NULL)) AS female
            FROM applications JOIN departments ON applications.department_id = departments.id
            GROUP BY departments.id, departments.name
            ORDER BY departments.name";
        $departments = DB::select($sql);
        $data = [
            'states' => $states,
            'departments' => $departments,
        ];

        return view("appl.index", $data);
    }

    public function department(\App\Models\Department $department){
        $males = Application::where('gender', 'Male')->where('department_id', $department->id)->get();
        $females = Application::where('gender', 'Female')->where('department_id', $department->id)->get();

        $data = [
            'males' => $males,
            'females' => $females,
            'department' => $department,
        ];
        return view('appl.department', $data);
    }


}
