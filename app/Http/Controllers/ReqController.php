<?php

namespace App\Http\Controllers;

use App\Models\Req;
use App\Models\AllotHostel;
use Illuminate\Http\Request;

class ReqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()) {
            if (auth()->user()->isWarden() && isset(request()->hostel_id)) {
                if (isset(request()->status) && request()->status == 'applied') {
                    $hostel = \App\Models\Hostel::findOrFail(request()->hostel_id);
                }
            } else if (auth()->user()->allotment()) {
                $allotment = auth()->user()->allotment();
                if ($allotment->valid_allot_hostel()) {
                    $allot_hostel = $allotment->valid_allot_hostel();
                    // return $allot_hostel;
                    return $allot_hostel->reqs();
                }

                return "Allotment";
            } else {
                return "Not yet";
            }
        } else {
            return "User not authenticated";
        }
    }

    public function allot_hostel_index(AllotHostel $allot_hostel)
    {
        $data = [
            'allot_hostel' => $allot_hostel,
            'reqs' => $allot_hostel->reqs(),
        ];
        return view('req.allot_hostel_index', $data);
        return $allot_hostel;
        return $allot_hostel->reqs();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(AllotHostel $allot_hostel)
    {
        // return $allot_hostel;
        $data = [
            'allot_hostel' => $allot_hostel,
            'hostels' => \App\Models\Hostel::where('gender', $allot_hostel->hostel->gender)->orderBy('name')->get(),
        ];
        return view('req.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AllotHostel $allot_hostel, Request $request)
    {
        $req = Req::create([
            'allot_hostel_id' => $allot_hostel->id,
            'from_hostel_id' => $request->from_hostel_id,
            'to_hostel_id' => $request->to_hostel_id,
        ]);
        return redirect('/allot_hostel/' . $allot_hostel->id . '/req')
            ->with(['message' => ['type' => 'info', 'text' => 'Request Successfully submitted']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Req $req)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Req $req)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Req $req)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Req $req)
    {
        //
    }
}
