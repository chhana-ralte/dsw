<?php

use App\Http\Controllers\SemfeeController;

Route::controller(\App\Http\Controllers\SemfeeController::class)->group(function () {
    Route::get('/semfee/', 'index')->middleware(['auth']);
    Route::post('/hostel/{id}/semfee/approveall', 'approveAll')->middleware(['auth']);
    Route::post('/hostel/{id}/semfee/confirmall', 'confirmAll')->middleware(['auth']);
    Route::post('/hostel/{id}/semfee/sendall', 'sendAll')->middleware(['auth']);
    Route::get('/allot_hostel/{id}/semfee/create', 'create')->middleware(['auth']);
    Route::get('/allot_hostel/{allot_hostel}/semfee', 'allot_hostel_index')->middleware(['auth']);
    Route::post('/allot_hostel/{id}/semfee', 'store')->middleware(['auth']);
    Route::get('/semfee/list/hostel/{id?}/{status?}', 'list')->middleware(['auth']);
    Route::post('/semfee/{id}/paymentUpdate', 'paymentUpdate')->middleware(['auth']);
    Route::post('/allotment/{allotment}/semfee', 'allotment-index')->middleware(['auth']);
});
