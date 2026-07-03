<?php

use App\Http\Controllers\ReqController;

Route::controller(\App\Http\Controllers\ReqController::class)->group(function () {
    Route::get('/req/', 'index')->middleware(['auth']);
    Route::get('/allot_hostel/{allot_hostel}/req/', 'allot_hostel_index')->middleware(['auth']);
    Route::get('/hostel/{hostel}/req/', 'hostel_index')->middleware(['auth']);
    Route::get('/allot_hostel/{allot_hostel}/req/create', 'create')->middleware(['auth']);
    Route::put('/req/{req}', 'update')->middleware(['auth']);
    Route::post('/allot_hostel/{allot_hostel}/req', 'store')->middleware(['auth']);
});
