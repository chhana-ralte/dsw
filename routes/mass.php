<?php



Route::get('/generateRooms', function () {
    // return view('generateRooms');
});

Route::post('/generateRooms', function () {
    $str = "";
    if (request()->password == "mzudsw") {
        $Hostel_name = request()->hostel;
        $hostel_name = strtolower($Hostel_name);

        if (App\Models\Hostel::where('name', $hostel_name)->exists()) {
            $hostel = App\Models\Hostel::where('name', $hostel_name)->first();
            $str .= "<br>Hostel already existed";
        } else {
            $hostel = App\Models\Hostel::create([
                'name' => $Hostel_name,
                'gender' => 'Male',
            ]);
            $str .= "<br>New Hostel created";
        }
        if (App\Models\User::where('username', $hostel_name)->exists()) {
            $user = App\Models\User::where('username', $hostel_name)->first();
            $str .= "<br>User already existed";
        } else {
            $user = App\Models\User::create([
                'name' => $Hostel_name,
                'username' => $hostel_name,
                'email' => $hostel_name . '@mzu.edu.in',
                'password' => Hash::make('password')
            ]);
            $str .= "<br>New user created";
        }

        // $dump = DB::table($hostel_name)->get();

        $rooms = DB::table($hostel_name)
            ->select('roomno', 'capacity', 'type')
            ->where('roomno', '<>', '')
            ->orderBy('roomno')
            ->groupBy('roomno', 'capacity', 'type')
            ->get();


        foreach ($rooms as $r) {
            $room = \App\Models\Room::updateOrCreate([
                'hostel_id' => $hostel->id,
                'roomno' => $r->roomno,
            ], [
                'hostel_id' => $hostel->id,
                'roomno' => $r->roomno,
                'type' => $r->capacity == 1 ? 'Single' : ($r->capacity == 2 ? "double" : ($r->capacity == 3 ? "Triple" : "Dorm")),
                'capacity' => $r->capacity,
                'available' => $r->capacity,
            ]);

            $str .= "<br>New room created:" . $room->roomno;
            for ($i = 0; $i < $r->capacity; $i++) {
                $seat = \App\Models\Seat::updateOrCreate([
                    'room_id' => $room->id,
                    'serial' => $i + 1,
                ], [
                    'room_id' => $room->id,
                    'serial' => $i + 1,
                    'available' => 1,
                ]);
                $str .= "<br>New Seat created: " . $seat->serial;
            }
        }


        $list_of_hostellers = DB::table($hostel->name)
            ->select('*')
            ->where('name', '<>', '')
            ->get();

        foreach ($list_of_hostellers as $l) {
            $person = App\Models\Person::create([
                'name' => $l->name,
                'state' => $l->state,
                'category' => $l->category,
                'address' => $l->address,
                'state' => $l->state,
                'mobile' => $l->mobile,
            ]);

            $str .= "New person " . $person->name . " created <br>";

            if ($l->course != '' || $l->department != '') {
                $student = App\Models\Student::create([
                    'person_id' => $person->id,
                    'course' => $l->course,
                    'department' => $l->department,
                    'mzuid' => $l->mzuid,

                ]);
                $str .= "New student " . $person->name . " created <br>";
            }



            $allotment = App\Models\Allotment::create([
                'person_id' => $person->id,
                'notification_id' => 1,
                'hostel_id' => $hostel->id,
                'from_dt' => $l->year . '-08-01',
                'to_dt' => '2025-07-31',
                'valid' => 1,
                'qfix' => $l->qfix
            ]);

            $str .= "New allotment " . $allotment->id . " created <br>";

            $allot_hostel = App\Models\AllotHostel::create([
                'allotment_id' => $allotment->id,

                'hostel_id' => $hostel->id,
                'from_dt' => $l->year . '-08-01',
                'to_dt' => '2025-07-31',
                'valid' => 1
            ]);

            $str .= "New allot_hostel in " . $hostel->name . " created <br>";

            $room = Room::where('roomno', $l->roomno)
                ->where('hostel_id', $hostel->id)
                ->first();

            $seats = Seat::where('room_id', $room->id)->orderBy('serial')->get();

            foreach ($seats as $s) {
                if (App\Models\AllotSeat::where('seat_id', $s->id)->exists())
                    continue;
                else {
                    App\Models\AllotSeat::create([
                        'allot_hostel_id' => $allot_hostel->id,
                        'seat_id' => $s->id,
                        'from_dt' => $l->year . '-08-01',
                        'to_dt' => '2025-07-31',
                        'valid' => 1
                    ]);
                    $str .= "Allotment in seat " . $s->roomno . "/" . $s->serial . " done <br>";
                    break;
                }
            }
        }
    }
    return $str;
});


Route::post('/generateRooms2', function () {
    if (request()->password == "mzudsw") {
        App\Models\Room::truncate();
        \App\Models\RoomRemark::truncate();
        $hostels = App\Models\Hostel::orderBy('gender')->orderBy('name')->get();
        // $hostels = App\Models\Hostel::whereIn('name',startUp())->orderBy('gender')->orderBy('name')->get();
        foreach ($hostels as $ht) {
            $rooms = DB::table('dump')
                ->select('Roomno', 'Capacity', 'Type')
                ->where('Hostel', $ht->name)
                ->where('Roomno', '<>', '')
                ->orderBy('Roomno')
                ->groupBy('Roomno', 'Capacity', 'Type')
                ->get();
            //return $rooms;
            foreach ($rooms as $r) {
                App\Models\Room::create([
                    'hostel_id' => $ht->id,
                    'roomno' => $r->Roomno,
                    'capacity' => $r->Capacity,
                    'available' => $r->Capacity,
                    'type' => $r->Type,
                ]);
            }
            //exit();
        }
        return "Room Generation Done";
    } else {
        return redirect('/generateRooms')->with(['message' => ['type' => 'info', 'text' => 'Incorrect Password']]);
    }
});

Route::get('/generateSeats', function () {
    // return view('generateSeats');
});

Route::post('/generateSeats', function () {
    if (request()->password == "mzudsw") {
        // App\Models\Seat::truncate();
        // App\Models\SeatRemark::truncate();

        // $hostels = Hostel::all();
        $hostel = Hostel::where('name', 'Transit')->first();
        $rooms = $hostel->rooms;

        foreach ($rooms as $r) {
            for ($i = 0; $i < $r->capacity; $i++) {
                Seat::create([
                    'room_id' => $r->id,
                    'serial' => $i + 1
                ]);
            }
        }
        return "Seat Generation Done";
    }
});

Route::get('/massAllot', function () {
    // return view('massAllot');
});
Route::post('/massAllot', function () {
    if (request()->password == "mzudsw") {

        App\Models\Person::truncate();
        App\Models\Student::truncate();
        App\Models\AllotHostel::truncate();
        App\Models\AllotSeat::truncate();

        // $hostels = App\Models\Hostel::whereIn('name',startUp())->orderBy('gender')->orderBy('name')->get();
        $hostels = Hostel::all();
        foreach ($hostels as $hostel) {
            $list_of_hostellers = DB::table($hostel->name)
                ->select('*')
                ->where('name', '<>', '')
                ->get();

            foreach ($list_of_hostellers as $l) {
                $person = App\Models\Person::create([
                    'name' => $l->Name,
                    // 'state' => $l->State,
                    // 'category' => $l->Category,
                    // 'address' => $l->State,
                    'phone' => $l->State,
                ]);

                if ($l->Course != '' || $l->Department != '') {
                    $student = App\Models\Student::create([
                        'person_id' => $person->id,
                        'course' => $l->Course,
                        'department' => $l->Department,
                        'mzuid' => $l->MZU_id
                    ]);
                }

                $allotment = App\Models\Allotment::create([
                    'person_id' => $person->id,
                    'hostel_id' => $hostel->id,
                    'from_dt' => $l->Year . '-08-01',
                    'to_dt' => '2025-07-31',
                    'valid' => 1
                ]);

                $allot_hostel = App\Models\AllotHostel::create([
                    'allotment_id' => $allotment->id,
                    'hostel_id' => $hostel->id,
                    'from_dt' => $l->Year . '-08-01',
                    'to_dt' => '2025-07-31',
                    'valid' => 1
                ]);

                $room = Room::where('roomno', $l->Roomno)
                    ->where('hostel_id', $hostel->id)
                    ->first();

                $seats = Seat::where('room_id', $room->id)->orderBy('serial')->get();

                foreach ($seats as $s) {
                    if (App\Models\AllotSeat::where('seat_id', $s->id)->exists())
                        continue;
                    else {
                        App\Models\AllotSeat::create([
                            'allot_hostel_id' => $allot_hostel->id,
                            'seat_id' => $s->id,
                            'from_dt' => '2024-08-01',
                            'to_dt' => '2025-07-31',
                            'valid' => 1
                        ]);
                        break;
                    }
                }
            }
        }
        return "Mass Allotment Done";
    }
});

Route::get('/newallot2', function () {
    $news = DB::table('allotment_1')->orderBy('id')->get();
    foreach ($news as $new) {
        $str1 = "Person ids : [";
        $str2 = "Student ids : [";
        $str3 = "Allotment ids : [";
        $person = App\Models\Person::create([
            'name' => $new->name,
            'category' => $new->category,
            'email' => $new->email,
            'state' => $new->state,
            'address' => $new->address,
            'mobile' => $new->phone,

        ]);
        $str1 .= $person->id . ", ";

        $student = App\Models\Student::create([
            'person_id' => $person->id,
            'department' => $new->department,
            'course' => $new->course,
            'mzuid' => $new->MZU_id,
        ]);
        $str2 .= $student->id . ", ";

        $allotment = App\Models\Allotment::create([
            'notification_id' => 2,
            'person_id' => $person->id,
            'hostel_id' => $new->hostel_id,
            'qfix' => $new->qfix,
            'valid' => 1,
            'admitted' => 0,
            'finished' => 0,
        ]);
        $str3 .= $allotment->id . ", ";
    }
    $str1 .= "]";
    $str2 .= "]";
    $str3 .= "]";

    return $str1 . "<br><br>" . $str2 . "<br><br>" . $str3;
});
