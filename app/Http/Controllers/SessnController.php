<?php

namespace App\Http\Controllers;

use App\Models\Sessn;
use Illuminate\Http\Request;

class SessnController extends Controller
{
    public function index()
    {
        $sessns = Sessn::orderBy('start_yr')->orderBy('odd_even')->get();
        return view('common.sessn.index',['sessns' => $sessns]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('common.sessn.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_yr' => ['required','integer','between:2000,2050'],
            'odd_even' => 'required'
        ]);

        if(Sessn::where('start_yr',$request->start_yr)->where('odd_even',$request->odd_even)->exists()){
            return redirect('/sessn/create')->with(['message' => ['type' => 'danger', 'text' => 'Session already exists']])->withInput();
        }
        else{
            $sessn = Sessn::create([
                'start_yr' => $request->start_yr,
                'end_yr' => substr($request->start_yr+1,-2),
                'odd_even' => $request->odd_even
            ]);
    
            if(isset($request->current)){
                Sessn::where('current',1)->update([ 'current' => 0]);
                $sessn->update(['current' => 1]);
            }
            
            return redirect('/sessn')->with(['message' => ['type' => 'info', 'text' => 'New session created']]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Sessn $sessn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sessn $sessn)
    {
        return view('common.sessn.edit',['sessn' => $sessn]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sessn $sessn)
    {
        $validated = $request->validate([
            'start_yr' => ['required','numeric'],
            'end_yr' => ['required','numeric'],
            'odd_even' => 'required'
        ]);

        $sessn->update($valodated);

        return redirect('/sessn')->with(['message' => ['type' => 'info', 'text' => 'Session updated']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sessn $sessn)
    {
        $sessn->delete();
        return redirect('/sessn')->with(['message' => ['type' => 'info', 'text' => 'Session deleted']]);
    }
}
