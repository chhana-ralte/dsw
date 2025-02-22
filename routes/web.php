<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Models\Room;
use App\Models\Hostel;
use App\Models\Seat;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\RoomController;

use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    //return "Hello";
    return view('welcome');
});

Route::get('/hostel/{hostel}/occupants',[HostelController::class,'occupants']);
Route::resource('hostel', HostelController::class);
Route::resource('hostel.room', RoomController::class)->shallow();



Route::get('/generateSeats', function(){
    return "Hello";
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
    return "Hello";
    foreach(App\Models\Hostel::all() as $hostel){
        $list = DB::table($hostel->name)
            ->select('*')
            ->where('name','<>','')
            ->get();

        // $str = "<table>";
        // foreach($list as $l){
        //     $str .= "<tr><td>"  . $l->Name . "</td></tr>";
        // }
        // $str .= "</table>";
        // return $str;
        foreach($list as $l){
            $person = App\Models\Person::create([
                'name' => $l->Name,
                'state' => $l->State,
                'category' => $l->Category,
                'address' => $l->State,
            ]);

            if($l->Course != '' && $l->Department != ''){
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
