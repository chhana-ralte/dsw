<?php

namespace App\Http\Controllers;

use App\Models\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    public function sql(){
        return view('query.exec', ['sql' => '']);
    }
    public function exec()
    {
        $results = DB::select(request()->sql);
        $sql = request()->sql;
        $data = [
            'sql' => $sql,
            'results' => $results,
        ];
        return view('query.exec', $data);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('query.index', ['queries' => Query::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('query.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // return $request;
        $query = Query::create([
            'title' => $request->title,
            'sql' => $request->sql
        ]);
        if(request()->has('ajax')){
            return $query;
        }
        else{
            return redirect('/query')
            ->with(['message' => ['type' => 'info', 'text' => 'Query created successfully']]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Query $query)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Query $query)
    {
        return view("query.edit", ['query' => $query]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Query $query)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Query $query)
    {
        $query->delete();
        return redirect('/query')
            ->with(['message' => ['type' => 'info', 'text' => 'Query deleted successfully']]);
    }
}
