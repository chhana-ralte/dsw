<?php

namespace App\Http\Controllers;

use App\Models\Semfee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemfeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (isset(request()->hostel_id)) {
            $allot_hostel = \App\Models\AllotHostel::find(3);
            $hostel = \App\Models\Hostel::find(request()->hostel_id);
            if(isset(request()->sessn_id)){
                $sessn = Sessn::find($sessn_id);
            }
            else{
                $sessn = \App\Models\Sessn::current();
            }
            if ($hostel) {
                $data = [
                    'sessn' => $sessn,
                    'hostel' => $hostel,
                    'allot_hostels' => $hostel->valid_allot_hostels()
                ];
                return view('semfee.index', $data);

            }
        }
        else{
            return redirect('/semfee/list/hostel');
            return view('semfee.index-none');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($allot_hostel_id)
    {
        $semfees = Semfee::where('allot_hostel_id', $allot_hostel_id)->orderBy('sessn_id')->get();
        $allot_hostel = \App\Models\AllotHostel::find($allot_hostel_id);
        $allot_seat = $allot_hostel->valid_allot_seat();
        if($allot_seat){
            $capacity =  $allot_seat->seat->room->capacity;
        }
        else{
            $capacity = 0;
        }
        if(isset(request()->sessn_id)){
            $sessn = \App\Models\Sessn::find(request()->sessn_id);
        }
        else{
            $sessn = \App\Models\Sessn::current();
        }

        $data = [
            'capacity' => $capacity,
            'semfees' => $semfees,
            'sessn' => $sessn,
            'allot_hostel' => $allot_hostel,

        ];
        return view('semfee.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($allot_hostel_id, Request $request)
    {
        $allot_hostel = \App\Models\AllotHostel::find($allot_hostel_id);
        $semfee = Semfee::updateOrCreate([
            'allot_hostel_id' => $allot_hostel_id,
            'sessn_id' => $request->sessn_id
        ],
        [
            'allotment_id' => $allot_hostel->allotment_id,
            'allot_hostel_id' => $allot_hostel_id,
            'sessn_id' => $request->sessn_id,
            'roomcapacity' => $request->capacity,
            'user_id' => auth()->user()->id,
            'valid' => 1,
            'status' => 'Forwarded',
        ]);
        return redirect('/allot_hostel/' . $allot_hostel_id . '/semfee/create')->with(['message' => ['type'=>'success', 'text'=> 'Successfully done.']]);
        return $semfee;
    }

    /**
     * Display the specified resource.
     */
    public function show(Semfee $semfee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Semfee $semfee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Semfee $semfee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semfee $semfee)
    {
        //
    }

    public function approveAll($hostel_id, Request $request){
        $allot_hostel_ids = $request->allot_hostel_id;
        $allot_hostels = \App\Models\AllotHostel::whereIn('id', $allot_hostel_ids)->get();
        $sessn = \App\Models\Sessn::find($request->sessn_id);
        $data = [
            'allot_hostels' => $allot_hostels,
            'hostel' => \App\Models\Hostel::find($hostel_id),
            'sessn' => $sessn,

        ];
        return view('semfee.confirmall', $data);


    }

    public function confirmAll($hostel_id, Request $request){
        // return $request;
        $str = "testing<br>";
        foreach($request->request as $key => $capacity){
            $t = explode('_', $key);
            if($t[0] == 'capacity'){
                $allot_hostel = \App\Models\AllotHostel::find($t[1]);
                Semfee::updateOrCreate([
                    'allot_hostel_id' => $allot_hostel->id,
                    'sessn_id' => $request->sessn_id
                ],
                [
                    'allotment_id' => $allot_hostel->allotment_id,
                    'allot_hostel_id' => $allot_hostel->id,
                    'sessn_id' => $request->sessn_id,
                    'roomcapacity' => $capacity,
                    'user_id' => auth()->user()->id,
                    'valid' => 1,
                    'status' => 'Forwarded',

                ]);
            }

        }

        return redirect('/semfee?hostel_id=' . $request->hostel_id)->with(['message' => ['type'=>'info', 'text'=>'Successfully done']]);
        return $str;
        $allot_hostel_ids = $request->allot_hostel_id;
        $allot_hostels = \App\Models\AllotHostel::whereIn('id', $allot_hostel_ids)->get();
        $sessn = \App\Models\Sessn::find($request->sessn_id);

        $arr = array();
        foreach($allot_hostel_ids as $id){
            $str = '$request->' . $id . '_capacity';
            array_push($arr, $str);
        }
        return $arr;
        $data = [
            'allot_hostels' => $allot_hostels,
            'hostel' => \App\Models\Hostel::find($hostel_id),
            'sessn' => $sessn,

        ];
        return view('semfee.confirmall', $data);


    }

    public function list(?int $hostel_id = 0, ?string $status = "forwarded"){
        if(isset(request()->sessn_id)){
            $sessn = \App\Models\Sessn::find(request()->sessn_id);
        }
        else{
            $sessn = \App\Models\Sessn::current();
        }
        if($hostel_id){
            $hostel = \App\Models\Hostel::find($hostel_id);
            $allot_hostels = $hostel->valid_allot_hostels();
            if($status == 'Null'){
                $data = [
                    'hostel' => $hostel,
                    'allot_hostels' => $allot_hostels,
                    'sessn' => $sessn
                ];
                return view('semfee.null-list', $data);
            }
            else{
                $semfees = Semfee::whereIn('allot_hostel_id',$allot_hostels->pluck('id'))->where('status', $status)->get();
                $data = [
                    'semfees' => $semfees,
                    'hostel' => $hostel,
                    'allot_hostels' => $allot_hostels,
                    'sessn' => $sessn
                ];
                return view('semfee.list', $data);
            }
        }
        else{
            $sql = "SELECT hostels.id, hostels.name, hostels.gender, count(allot_hostels.id) - count(semfees.id) AS 'Null',
                count(if(semfees.status = 'Forwarded',1,null)) AS 'Forwarded',
                count(if(semfees.status = 'Sent',1,null)) AS 'Sent',
                count(if(semfees.status = 'Paid',1,null)) AS 'Paid',
                count(if(semfees.status = 'Cancelled',1,null)) AS 'Cancelled'
                FROM hostels JOIN allot_hostels ON hostels.id=allot_hostels.hostel_id AND allot_hostels.valid = 1
                LEFT JOIN semfees ON allot_hostels.id = semfees.allot_hostel_id
                GROUP BY hostels.id,hostels.name, hostels.gender
                ORDER BY hostels.gender, hostels.name";
            $semfees = DB::select($sql);
            return view('semfee.index-none',['semfees' => $semfees]);
        }
    }
}
