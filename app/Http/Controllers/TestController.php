<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        return view("test.index", ['tests' => Test::all()]);
        return "Hello";
    }
    public function create()
    {
        return view("test.create");
        return "create";
    }

    public function store(Request $request)
    {

        if(Test::insert($request)){
            return redirect('/testing')->with(['message' => ['type' => 'info', 'text' => 'Successfully inserted']]);
        }
        return Test::insert(['num' => $request->num]);
        return request()->num;
    }

    public function show($id)
    {
        return view("test.show", ['test' => Test::find($id)]);
    }

    public function edit($id)
    {
        return view("test.edit", ['test' => Test::find($id)]);
    }

    public function update($id, Request $request){
        $test = Test::find($id);
        return $test->update2($request);
    }

    public function destroy($id){
        $test = Test::find($id);
        return $test->delete();
    }
}
