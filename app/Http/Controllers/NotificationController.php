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
            'type' => $request->type,
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
        return view('common.notification.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        $data = [
            'notification' => $notification
        ];
        return view('common.notification.edit', $data);
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
            'type' => $request->type,
            'status' => $request->status,

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

    public function printable($id)
    {
        $notification = Notification::findOrFail($id);

        $allotments = $notification->allotments;

        $sem_allots = $notification->sem_allots;
        $data = [
            'notification' => $notification,
            'allotments' => $allotments,
            'sem_allots' => $sem_allots,
        ];
        return view('common.notification.printable', $data);
    }

    public function check()
    {

        return view('common.notification.check', ['str' => '']);
    }

    public function checkStore()
    {
        if (request()->has('str')) {
            $arr = explode('/', request()->str);
            if (sizeof($arr) == 3) {
                $notification = Notification::where('id', $arr[0])->first();
                if ($notification && $notification->type == 'sem_allot') {
                    $sem_allot = \App\Models\SemAllot::where('notification_id', $arr[0])->where('rand', $arr[1])->where('sl', $arr[2])->first();
                    return view('common.notification.check', ['sem_allot' => $sem_allot, 'str' => request()->str]);
                }
                else if($notification && $notification->type == 'allotment'){
                    $allotment = \App\Models\Allotment::where('notification_id', $arr[0])->where('rand', $arr[1])->where('sl', $arr[2])->first();
                    return view('common.notification.check', ['allotment' => $allotment, 'str' => request()->str]);
                }
                return redirect('/notification/check')->with(['message' => ['type' => 'info', 'text' => 'Reference not found.']])->withInput();
            }
            return redirect('/notification/check')->with(['message' => ['type' => 'info', 'text' => 'Incorrect reference format. use x/y/z where x and z are numbers, y is 2 alpabets string']])->withInput();
        }
        return redirect('/notification/check')->with(['message' => ['type' => 'info', 'text' => 'Reference not found.']])->withInput();
    }
}
