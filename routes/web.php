<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Models\Room;
use App\Models\Hostel;
use App\Models\Seat;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeatController;

use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return "Hello";
    return view('welcome');
});
Route::get('/h', function(){
    $hostel = Hostel::where('name',$_GET['hostel'])->first();
    return $hostel->vacant();
});
Route::get('/hostel/{hostel}/occupants',[HostelController::class,'occupants']);
Route::resource('hostel', HostelController::class);
Route::resource('hostel.room', RoomController::class)->shallow();
Route::resource('room.seat', SeatController::class)->shallow();

Route::get('generateRooms' ,function(){
    return "Hello";
    App\Models\Room::truncate();
    $hostels = App\Models\Hostel::orderBy('gender')->orderBy('name')->get();
    foreach($hostels as $ht){
        $rooms = DB::table($ht->name)
            ->select('Roomno','Type')
            ->where('Roomno','<>','')
            ->orderBy('Roomno')
            ->groupBy('Roomno','Type')
            ->get();
            //return $rooms;
        foreach($rooms as $r){
            $capacity = ($r->Type == 'Single' ? 1 : ($r->Type == 'Double' ? 2 : 3));
            App\Models\Room::create([
                'hostel_id' => $ht->id,
                'roomno' => $r->Roomno,
                'capacity' => $capacity,
                'available' => $capacity,
                'type' => $r->Type
            ]);
        }
        //exit();
    }
    return "Done";
});

Route::get('/generateSeats', function(){
    return "Comment out to generate seats";
    exit();
    App\Models\Seat::truncate();
    $rooms = Room::all();

    foreach($rooms as $r){
        for($i=0; $i < $r->capacity ; $i++){
            Seat::create([
                'room_id' => $r->id,
                'serial' => $i+1
            ]);
        }
    }
    return "Done";
});

Route::get('/allot',function(){
    return "Comment out to allot hostels";
    exit();
    App\Models\Person::truncate();
    App\Models\Student::truncate();
    App\Models\AllotHostel::truncate();
    App\Models\AllotSeat::truncate();
    foreach(App\Models\Hostel::all() as $hostel){
        $list_of_hostellers = DB::table($hostel->name)
            ->select('*')
            ->where('name','<>','')
            ->get();

        // $str = "<table>";
        // foreach($list as $l){
        //     $str .= "<tr><td>"  . $l->Name . "</td></tr>";
        // }
        // $str .= "</table>";
        // return $str;
        foreach($list_of_hostellers as $l){
            $person = App\Models\Person::create([
                'name' => $l->Name,
                'state' => $l->State,
                'category' => $l->Category,
                'address' => $l->State,
            ]);

            if($l->Course != '' || $l->Department != ''){
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

            $room = Room::where('roomno',$l->Roomno)
                ->where('hostel_id',$hostel->id)
                ->first();

            $seats = Seat::where('room_id',$room->id)->orderBy('serial')->get();
            
            foreach($seats as $s){
                if(App\Models\AllotSeat::where('seat_id',$s->id)->exists())
                    continue;
                else{
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
    return "Done";
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
