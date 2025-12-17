<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::where('section_id', 0)->orderBy('name')->get();
        return view('section.index', ['sections' => $sections]);

        return view('section.index', ['sections' => Section::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('section.create', ['sections' => Section::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Section::create([
            'name' => $request->name,
            'abbr' => $request->abbr,
            'section_id' => $request->section
        ]);
        return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        //
    }
}
