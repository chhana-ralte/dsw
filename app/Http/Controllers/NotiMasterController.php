<?php

namespace App\Http\Controllers;

use App\Models\NotiMaster;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotiMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user() && auth()->user()->can('views', Notification::class)) {
            $noti_masters = NotiMaster::orderBy('dt')->get();
            return view('common.notiMaster.index', ['noti_masters' => $noti_masters]);
        }
        return redirect()->back()->with(['message' => ['type' => 'warning', 'text' => 'Unauthorised']]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user() && auth()->user()->can('manages', Notification::class)) {
            return view('common.notiMaster.create');
        }
        return redirect()->back()->with(['message' => ['type' => 'warning', 'text' => 'Unauthorised']]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $noti_master = NotiMaster::create([
            'no' => $request->no,
            'dt' => $request->dt,
            'type' => $request->type,
            'content' => $request->content,
        ]);
        return redirect('/notiMaster')->with(['message' => ['type' => 'info', 'text' => 'Notification created']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(NotiMaster $notiMaster)
    {
        if (auth()->user() && auth()->user()->can('views', Notification::class)) {
            $filelinks = \App\Models\Filelink::where('type', 'noti_master')->where('foreign_id', $notiMaster->id)->get();
            $notifications = Notification::where('noti_master_id', $notiMaster->id)->orderBy('no')->get();
            $data = [
                'noti_master' => $notiMaster,
                'notifications' => $notifications,
                'filelinks' => $filelinks,
            ];
            return view('common.notiMaster.show', $data);
        }
        return redirect('/notiMaster')->with(['message' => ['type' => 'info', 'text' => 'Notification created']]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotiMaster $notiMaster)
    {
        if (auth()->user() && auth()->user()->can('manages', Notification::class)) {
            $notifications = Notification::where('noti_master_id', $notiMaster->id)->orderBy('no')->get();
            return view('common.notiMaster.edit', ['noti_master' => $notiMaster, 'notifications' => $notifications]);
        }
        return redirect('/notiMaster')->with(['message' => ['type' => 'info', 'text' => 'Notification created']]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NotiMaster $notiMaster)
    {
        $notiMaster->update([
            'no' => $request->no,
            'dt' => $request->dt,
            'type' => $request->type,
            'content' => $request->content,
        ]);
        $notiMaster->save();
        return redirect('/notiMaster/' . $notiMaster->id)->with(['message' => ['type' => 'info', 'text' => 'Notification updated']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotiMaster $notiMaster)
    {
        //
    }

    public function addToNotiMaster()
    {
        if (request()->has('notification_ids')) {
            $notifications = \App\Models\Notification::whereIn('id', request()->input('notification_ids'))->get();
            Notification::whereIn('id', request()->input('notification_ids'))->update([
                'noti_master_id' => request()->noti_master_id
            ]);
        }
        return redirect()->back()->with(['message' => ['type' => 'info', 'text' => 'Notification updated']]);
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
            'type' => 'noti_master',
            'foreign_id' => request()->noti_master_id,
            'tagname' => request()->tagname,
        ]);
        return redirect('/noti_master/' . request()->noti_master_id)->with(['message' => ['type' => 'info', 'text' => 'File update successfully']]);
    }
}
