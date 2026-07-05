<?php

namespace App\Http\Controllers;

use App\Models\Req;
use App\Models\AllotHostel;
use App\Models\AllotSeat;
use App\Models\Hostel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user() && auth()->user()->isDsw()){
            $reqs = Req::where('recommended1_by','<>',0)
                ->where('recommended2_by','<>',0)
                ->where('approved_by',0)
                ->get();
            $data = [
                'reqs' => $reqs
            ];
            return view('req.index', $data);
        }
    }

    public function allot_hostel_index(AllotHostel $allot_hostel)
    {
        $data = [
            'allot_hostel' => $allot_hostel,
            'reqs' => $allot_hostel->reqs(),
        ];
        return view('req.allot_hostel_index', $data);
    }

    public function hostel_index(Hostel $hostel)
    {

        $inbound_reqs = Req::where('to_hostel_id', $hostel->id)
            ->whereNot('recommended1_by',0)
            ->where('recommended2_by',0)
            ->orderBy('recommended1_on')
            ->get();

        $outbound_reqs = Req::where('from_hostel_id', $hostel->id)->where('recommended1_by',0)->orderBy('created_at')->get();

        $data = [
            'hostel' => $hostel,
            'inbound_reqs' => $inbound_reqs,
            'outbound_reqs' => $outbound_reqs,
        ];
        // return $data;
        return view('req.hostel_index', $data);
    }


    public function create(AllotHostel $allot_hostel)
    {
        // return $allot_hostel;
        $data = [
            'allot_hostel' => $allot_hostel,
            'hostels' => \App\Models\Hostel::where('gender', $allot_hostel->hostel->gender)->whereNot('id',$allot_hostel->hostel_id)->orderBy('name')->get(),
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
        if(auth()->user()->can('edit', $allot_hostel->allotment)){
            $req->update([
                'recommended1_by' => auth()->user()->id,
                'recommended1_on' => today()
            ]);
        }
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
        return $req->id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Req $req)
    {
        if($request->type == 'recommended1'){
            $req->update([
                'recommended1_by' => auth()->user()->id,
                'recommended1_on' => today(),
                'status' => 'Recommended1'
            ]);
        }
        else if($request->type == 'recommended2'){
            $req->update([
                'recommended2_by' => auth()->user()->id,
                'recommended2_on' => today(),
                'status' => 'Recommended2'
            ]);
        }
        else if($request->type == 'approved'){

            $allot_hostel = AllotHostel::findOrFail($req->allot_hostel_id);
            DB::transaction(function() use ($req, $allot_hostel){
                $req->update([
                    'approved_by' => auth()->user()->id,
                    'approved_on' => today(),
                    'status' => 'Approved'
                ]);

                //

                $new_allot_hostel = AllotHostel::create([
                    'allotment_id' => $allot_hostel->allotment_id,
                    'hostel_id' => $req->to_hostel_id,
                    'from_dt' => today(),
                    'to_dt' => $allot_hostel->to_dt,
                    'valid' => 1
                ]);

                AllotSeat::where('allot_hostel_id', $allot_hostel->id)->where('valid',1)->update([
                    'valid' => 0,
                    'to_dt' => today(),
                    'leave_dt' => today()
                ]);

                $allot_hostel->update([
                    'to_dt' => today(),
                    'leave_dt' => today(),
                    'valid' => 0
                ]);
            });
            // }
            // catch(\Throwable $e){
            //     return response()->json(['error' => $e->getMessage()], 500);
            // }

        }
        return $req;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Req $req)
    {
        //
    }
}
