<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsolidateController extends Controller
{
    public function index()
    {
        if (isset($_GET['type'])) {
            if ($_GET['type'] == "Course") {
                $type = $_GET['type'];
                $lists = DB::table('students')
                    ->groupBy('course')
                    ->select('course as name', DB::raw('count(*) as count'))
                    ->orderBy('course')
                    ->get();
            } else if ($_GET['type'] == "Department") {
                $type = $_GET['type'];
                $lists = DB::table('students')
                    ->groupBy('department')
                    ->select('department as name', DB::raw('count(*) as count'))
                    ->orderBy('department')
                    ->get();
            } else if ($_GET['type'] == "Category") {
                $type = $_GET['type'];
                $lists = DB::table('people')
                    ->groupBy('category')
                    ->select('category as name', DB::raw('count(*) as count'))
                    ->orderBy('category')
                    ->get();
            } else {
                $type = "x";
                $lists = null;
            }
        } else {
            $type = "x";
            $lists = null;
        }
        $data = [
            'type' => $type,
            'lists' => $lists,
        ];
        return view('consolidate.index', $data);
    }

    public function detail()
    {
        if (isset($_GET['type'])) {
            if ($_GET['type'] == "Course") {
                $type = $_GET['type'];
                $lists = DB::table('students')->join('people', 'people.id', 'students.person_id')
                    ->select('name', 'rollno', 'course', 'department')
                    ->where('course', request()->str)
                    ->orderBy('name')
                    ->get();
            } else if ($_GET['type'] == "Department") {
                $type = $_GET['type'];
                $lists = DB::table('students')->join('people', 'people.id', 'students.person_id')
                    ->select('name', 'rollno', 'course', 'department')
                    ->where('department', request()->str)
                    ->orderBy('name')
                    ->get();
            } else if ($_GET['type'] == "Category") {
                $type = $_GET['type'];
                $lists = DB::table('people')
                    ->where('category', request()->str)
                    ->select('name', 'category')
                    ->orderBy('name')
                    ->get();
            } else {
                $type = "x";
                $lists = null;
            }
        } else {
            $type = "x";
            $lists = null;
        }
        $data = [
            'type' => $type,
            'lists' => $lists,
        ];
        // return $data;
        return view('consolidate.detail', $data);
    }
    public function store()
    {
        if (request()->type == "Course") {
            \App\Models\Student::whereIn('course', request()->list)->update([
                'course' => request()->name,
            ]);
        } else if (request()->type == "Department") {
            \App\Models\Student::whereIn('department', request()->list)->update([
                'department' => request()->name,
            ]);
        } else if (request()->type == "Category") {
            \App\Models\Person::whereIn('category', request()->list)->update([
                'category' => request()->name,
            ]);
        } else {
            return redirect('/consolidate?type=' . request()->type)->with(['message' => ['type' => 'danger', 'text' => 'Unsuccessful']]);
        }
        return redirect('/consolidate?type=' . request()->type)->with(['message' => ['type' => 'info', 'text' => 'Updated']]);
    }
}
