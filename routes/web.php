<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

use App\Models\Room;
use App\Models\Hostel;
use App\Models\Seat;

use App\Http\Controllers\HostelController;
use App\Http\Controllers\WardenController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AllotmentController;
use App\Http\Controllers\AllotHostelController;
use App\Http\Controllers\AllotSeatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\PersonRemarkController;
use App\Http\Controllers\PersonRemarkDetailController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessnController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AdmissionCheckController;
use App\Http\Controllers\CancelSeatController;
use App\Http\Controllers\ConsolidateController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

Route::get('/test', function () {
    return "Hehe";
})->middleware(['auth', 'admin']);
Route::get('/', [HostelController::class, 'index']);
Route::get('/warden', [WardenController::class, 'list']);
Route::get('/search', [SearchController::class, 'index'])->middleware(['auth']);
Route::get('/consolidate', [ConsolidateController::class, 'index'])->middleware(['auth']);
Route::get('/consolidateDetail', [ConsolidateController::class, 'detail'])->middleware(['auth']);
Route::post('/consolidate', [ConsolidateController::class, 'store'])->middleware(['auth']);
Route::get('/admissioncheck', [AdmissionCheckController::class, 'check']);
Route::post('/admissioncheck', [AdmissionCheckController::class, 'checkStore']);
Route::post('/allotment/{id}/admission_decline', [AdmissionController::class, 'admission_decline']);
Route::get('/allotment/{id}/admission', [AdmissionCheckController::class, 'status']);



Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'logincheck']);
Route::get('/user/changePassword', [UserController::class, 'changePassword'])->middleware('auth');
Route::post('/user/changePassword', [UserController::class, 'changePasswordStore']);
Route::post('/logout', [UserController::class, 'logout']);
Route::get('/hostel/{hostel}/occupants', [HostelController::class, 'occupants'])->middleware('auth');
Route::post('/allotment/{allotment}/clear_allotment', [AllotmentController::class, 'clear_allotment'])->middleware('auth');

Route::resource('person', PersonController::class)->middleware('auth');
Route::resource('person.student', StudentController::class)->shallow()->middleware('auth');
Route::resource('person.other', OtherController::class)->shallow()->middleware('auth');
Route::resource('person.person_remark', PersonRemarkController::class)->shallow()->middleware('auth');
Route::resource('person_remark.person_remark_detail', PersonRemarkDetailController::class)->shallow()->middleware('auth');
Route::resource('hostel', HostelController::class);
Route::resource('hostel.room', RoomController::class)->shallow()->middleware('auth');
Route::resource('hostel.warden', WardenController::class)->shallow()->middleware(['auth', 'admin']);
Route::resource('hostel.admission', AdmissionController::class)->shallow()->middleware('auth');
Route::resource('room.seat', SeatController::class)->shallow()->middleware('auth');
Route::resource('notification', NotificationController::class)->middleware('auth');
Route::resource('notification.allotment', AllotmentController::class)->shallow()->middleware('auth');
Route::resource('allotment.allot_hostel', AllotHostelController::class)->shallow()->middleware('auth');
Route::resource('allotment.cancelSeat', CancelSeatController::class)->shallow()->middleware('auth');
Route::resource('user', UserController::class)->middleware(['auth']);
Route::resource('allotment.admission', AdmissionController::class)->shallow()->middleware('auth');

Route::resource('sessn', SessnController::class)->middleware(['auth']);

Route::get('/allot_hostel/{id}/allotSeat', [AllotSeatController::class, 'allotSeat'])->middleware('auth');
Route::post('/allot_hostel/{id}/allotSeat', [AllotSeatController::class, 'allotSeatStore']);

Route::get('/seat/{id}/allotSeat', [SeatController::class, 'allotSeat'])->middleware('auth');
Route::post('/seat/{id}/allotSeat', [SeatController::class, 'allotSeatStore']);

Route::post('/room/{id}/unavailable', [RoomController::class, 'unavailable'])->middleware('auth');
Route::get('/room/{id}/editseatavailability', [RoomController::class, 'editseatavailability'])->middleware('auth');
Route::post('/room/{id}/editseatavailability', [RoomController::class, 'updateseatavailability']);
Route::get('/room/{id}/remark', [RoomController::class, 'remark'])->middleware('auth');
Route::post('/room/{id}/remark', [RoomController::class, 'remarkStore']);
Route::get('/seat/{id}/remark', [SeatController::class, 'remark'])->middleware('auth');
Route::post('/seat/{id}/remark', [SeatController::class, 'remarkStore']);
Route::delete('/room/remark/{id}', [RoomController::class, 'remarkDelete']);

Route::get('/person/{id}/confirm_delete', [PersonController::class, 'delete'])->middleware('auth');

Route::controller(App\Http\Controllers\StudentRegistrationController::class)->group(function () {
    Route::get('/studentRegistration', 'registration');
    Route::post('/studentRegistration', 'registrationStore');
    Route::get('/studentRegistration/create_user', 'create_user');
    Route::post('/studentRegistration/create_user_store', 'create_user_store');
});

Route::controller(App\Http\Controllers\AjaxController::class)->group(function () {
    Route::get('/ajaxroom/{id}/seat', 'getSeats');
    Route::get('/ajax/hostel/{id}/allot_hostel', 'getAllotHostels');
    Route::get('/ajax/get_available_seats', 'get_available_seats');
    Route::get('/ajax/get_all_seats', 'get_all_seats');
    Route::get('/ajax/get_role/{id}', 'get_role');
    Route::post('/ajax/allot_seat_store', 'allotSeatStore');
    Route::post('/ajax/seat/{id}/deallocate', 'deallocateSeat');
    Route::post('/ajax/manage_admission', 'manage_admission');
})->middleware('auth');








Route::get('/generateRooms', function () {
    return view('generateRooms');
});
function startUp()
{
    $hostels = ['thorang'];
    return $hostels;
}
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
                'gender' => 'Female',
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
                // 'address' => $l->State,
                'mobile' => $l->mobile,
            ]);

            $str .= "New person " . $person->name . " created <br>";

            if ($l->course != '' || $l->department != '') {
                $student = App\Models\Student::create([
                    'person_id' => $person->id,
                    'course' => $l->course,
                    'department' => $l->department,
                    'mzuid' => $l->mzuid
                ]);
                $str .= "New student " . $person->name . " created <br>";
            }



            $allotment = App\Models\Allotment::create([
                'person_id' => $person->id,
                'notification_id' => 1,
                'hostel_id' => $hostel->id,
                'from_dt' => $l->year . '-08-01',
                'to_dt' => '2025-07-31',
                'valid' => 1
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
                        'from_dt' => '2024-08-01',
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
    return view('generateSeats');
});

Route::post('/generateSeats', function () {
    if (request()->password == "mzudsw") {
        App\Models\Seat::truncate();
        App\Models\SeatRemark::truncate();

        // $hostels = Hostel::all();
        $rooms = Room::all();

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
    return view('massAllot');
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__ . '/auth.php';
