<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Models\Room;
use App\Models\Hostel;
use App\Models\Seat;

use App\Http\Controllers\HostelController;
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

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

Route::get('/', [HostelController::class, 'index']);
Route::get('/search', [SearchController::class, 'index'])->middleware(['auth']);
Route::get('/admissioncheck', [AdmissionCheckController::class, 'check']);
Route::post('/admissioncheck', [AdmissionCheckController::class, 'checkStore']);
Route::post('/allotment/{id}/admission_decline', [AdmissionController::class , 'admission_decline']);
Route::get('/allotment/{id}/admission', [AdmissionCheckController::class , 'status']);

Route::get('/message', function(){
    return view('message');
})->middleware(['auth']);
Route::get('/h', function () {
    $hostel = Hostel::where('name', $_GET['hostel'])->first();
    return $hostel->vacant();
});

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
Route::resource('hostel.admission', AdmissionController::class)->shallow()->middleware('auth');
Route::resource('room.seat', SeatController::class)->shallow()->middleware('auth');
Route::resource('notification', NotificationController::class)->middleware('auth');
Route::resource('notification.allotment', AllotmentController::class)->shallow()->middleware('auth');
Route::resource('allotment.allot_hostel', AllotHostelController::class)->shallow()->middleware('auth');
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
    $hostels = [['name' => 'Derhken']];
    // $hostels = App\Models\Hostel::all();
    // return $hostels;
    $str = "";
    foreach($hostels as $h){
        if (request()->password == "mzudsw") {
            if( App\Models\Hostel::where('name',$h['name'])->exists()){
                $hostel = App\Models\Hostel::where('name',$h['name'])->first();
            }
            else{
                $hostel = App\Models\Hostel::create([
                    'name' => $h['name'],
                    'gender' => 'Female',
                ]);
            }
            if(App\Models\User::where('username',$h['name'])->exists()){
                $user = App\Models\User::where('username',$h['name'])->first();
            }
            else{
                $user = App\Models\User::create([
                    'name' => $h['name'],
                    'username' => $h['name'],
                    'email' => 'derhken@mzu.edu.in',
                    'password' => Hash::make('password')
                ]);
            }

            $dump = DB::table($h['name'])->get();
            foreach($dump as $r){
                $room = \App\Models\Room::create([
                    'hostel_id' => $hostel->id,
                    'roomno' => $r->roomno,
                    'type' => 'Dorm',
                    'capacity' => $r->capacity,
                    'available' => $r->capacity,
                ]);
                for($i=0; $i < $r->capacity; $i++){
                    $seat = \App\Models\Seat::create([
                        'room_id' => $room->id,
                        'serial' => $i + 1,
                        'available' => 1,
                    ]);
                }
            }
        }
    }
    return "Completed";
});
Route::post('/generateRooms2', function () {
    if (request()->password == "mzudsw") {
        App\Models\Room::truncate();
        \App\Models\RoomRemark::truncate();
        $hostels = App\Models\Hostel::orderBy('gender')->orderBy('name')->get();
        // $hostels = App\Models\Hostel::whereIn('name',startUp())->orderBy('gender')->orderBy('name')->get();
        foreach ($hostels as $ht) {
            $rooms = DB::table('dump')
                ->select('Roomno', 'Capacity','Type')
                ->where('Hostel', $ht->name)
                ->where('Roomno', '<>', '')
                ->orderBy('Roomno')
                ->groupBy('Roomno', 'Capacity','Type')
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
            $list_of_hostellers = DB::table('dump')
                ->select('*')
                ->where('Hostel', $hostel->name)
                ->where('name', '<>', '')
                ->get();

            foreach ($list_of_hostellers as $l) {
                $person = App\Models\Person::create([
                    'name' => $l->Name,
                    'state' => $l->State,
                    'category' => $l->Category,
                    'address' => $l->State,
                ]);

                if ($l->Course != '' || $l->Department != '') {
                    $student = App\Models\Student::create([
                        'person_id' => $person->id,
                        'course' => $l->Course,
                        'department' => $l->Department,
                        'mzuid' => $l->MZU_id
                    ]);
                }

                $allot_hostel = App\Models\AllotHostel::create([
                    'person_id' => $person->id,
                    'hostel_id' => $hostel->id,
                    'from_dt' => '2024-08-01',
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__ . '/auth.php';
