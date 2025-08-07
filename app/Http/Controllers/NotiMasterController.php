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
        $noti_masters = NotiMaster::orderBy('dt')->get();
        return view('common.notiMaster.index', ['noti_masters' => $noti_masters]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('common.notiMaster.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $noti_master = NotiMaster::create([
            'no' => $request->no,
            'dt' => $request->dt,
            'content' => $request->content,
            'type' => $request->type,
        ]);
        return redirect('/notiMaster')->with(['message' => ['type' => 'info', 'text' => 'Notification created']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(NotiMaster $notiMaster)
    {
        $notifications = Notification::where('noti_master_id', $notiMaster->id)->orderBy('no')->get();
        return view('common.notiMaster.show', ['noti_master' => $notiMaster, 'notifications' => $notifications]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotiMaster $notiMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NotiMaster $notiMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotiMaster $notiMaster)
    {
        //
    }
}
