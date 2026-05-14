<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        return view("test.index");
        return "Hello";
    }
    public function create()
    {
        return view("test.create");
        return "create";
    }
    public function store(Request $request)
    {
        return Test::insert(['num' => $request->num]);
        return request()->num;
    }
    public function show($id)
    {
        return "ID is " . $id;
    }
}
