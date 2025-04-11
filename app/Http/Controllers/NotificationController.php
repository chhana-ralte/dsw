<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'notifications' => Notification::orderBy('dt')->get()
        ];
        return view("common.notification.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('common.notification.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $notification = Notification::create([
            'no' => $request->no,
            'dt' => $request->dt,
            'content' => $request->content,
        ]);
        return redirect('/notification')->with(['message' => ['type' => 'info', 'text' => 'Notification created']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        $data = [
            'notification' => $notification
        ];
        return view('common.notification.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        $data = [
            'notification' => $notification
        ];
        return view('common.notification.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        $notification->update([
            'no' => $request->no,
            'dt' => $request->dt,
            'content' => $request->content,
        ]);
        return redirect('/notification/' . $notification->id)->with(['message' => ['type' => 'info', 'text' => 'Notification updated']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect('/notification')->with(['message' => ['type' => 'info', 'text' => 'Notification deleted']]);
    }
}
