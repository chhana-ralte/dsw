<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hostel;
use App\Models\Person;
use App\Models\Warden;

class WardenController extends Controller
{
    public function all()
    {
        $data = [
            Warden::all()
        ];
        return view('common.warden.all', $data);
    }

    public function list()
    {
        $data = [
            'wardens' => Warden::where('valid', 1)->get()
        ];
        return view('common.warden.list', $data);
    }

    public function index(Hostel $hostel)
    {
        $data = [
            'hostel' => $hostel,
            'wardens' => Warden::where('hostel_id', $hostel->id)->orderBy('from_dt')->get(),
            'warden' => Warden::where('hostel_id', $hostel->id)->where('valid', 1)->first()
        ];
        return view('common.warden.index', $data);
    }

    public function create(Hostel $hostel)
    {
        // return "Hello";
        $data = [
            'hostel' => $hostel
        ];
        return view('common.warden.create', $data);
    }

    public function store(Request $request, Hostel $hostel)
    {
        $validated = (object)$request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric',
            'email' => 'required|email',
            'from_dt' => 'required',
            'to_dt' => 'required',
            'hostel_id' => 'required',
        ]);

        $person = Person::create([
            'name' => $validated->name,
            'mobile' => $validated->mobile,
            'email' => $validated->email,
        ]);

        $warden = Warden::create([
            'person_id' => $person->id,
            'hostel_id' => $validated->hostel_id,
            'from_dt' => $validated->from_dt,
            'to_dt' => $validated->to_dt,
        ]);

        if ($request->valid) {
            Warden::where('hostel_id', $validated->hostel_id)->where('valid', 1)->update(['valid' => 0]);
            $warden->update(['valid' => 1]);
        } else {
            $warden->update(['valid' => 0]);
        }

        return redirect('/hostel/' . $hostel->id . '/warden');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Warden::where('hostel_id', $request->hostel_id)->where('valid', 1)->update(['valid' => 0]);
        Warden::where('id', $id)->update(['valid' => 1]);
        return "Successfully updated";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
