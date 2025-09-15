<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sop;

class SopController extends Controller
{
    public function index()
    {
        return view('sop.index', ['sops' => Sop::all()]);
    }

    public function create()
    {
        return view('sop.create');
    }

    public function store()
    {
        $sop = Sop::create([
            'title' => request()->title,
            'content' => request()->content,
        ]);

        return redirect('/sop')->with(['message' => ['type' => 'info', 'text' => 'SOP created successfully']]);
        return request()->all();
    }

    // public function

    public function show(Sop $sop)
    {
        $filelinks = \App\Models\Filelink::where('type', 'sop')->where('foreign_id', $sop->id)->get();
        // $files = \App\Models\File::whereIn('id', $filelinks->pluck('file_id'))->get();
        return view('sop.show', ['sop' => $sop, 'filelinks' => $filelinks]);
    }

    public function edit(Sop $sop)
    {
        return view('sop.edit', ['sop' => $sop]);
    }

    public function update(Sop $sop)
    {
        $sop->update([
            'title' => request()->title,
            'content' => request()->content,
        ]);
        return redirect('/sop/' . $sop->id)->with(['message' => ['type' => 'info', 'text' => 'SOP updated successfully']]);
    }

    public function destroy(Sop $sop)
    {
        $sop->delete();
        return redirect('/sop/')->with(['message' => ['type' => 'info', 'text' => 'SOP deleted successfully']]);
    }


    public function fileupload()
    {
        // return request()->all();
        // return request()->file('file')->store('uploads', 'public');
        $newfile = \App\Models\File::upload(request()->file('file'), [
            'type' => 'document',
            'name' => request()->filename,
            'remark' => 'remark'
        ]);

        $filelink = \App\Models\Filelink::create([
            'file_id' => $newfile->id,
            'type' => 'sop',
            'foreign_id' => request()->sop_id,
            'tagname' => request()->tagname,
        ]);
        return redirect('/sop/' . request()->sop_id)->with(['message' => ['type' => 'info', 'text' => 'File update successfully']]);
    }
}
