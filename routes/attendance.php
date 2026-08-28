<?php

use App\Http\Controllers\AttController;
use App\Http\Controllers\EnrollController;
use App\Http\Controllers\AttmasterController;
use App\Http\Controllers\StdController;

Route::controller(\App\Http\Controllers\AttmasterController::class)->group(function () {
    Route::get('/att/attmaster/create', 'create'); //->middleware(['auth']);
    Route::post('/att/attmaster/', 'store'); //->middleware(['auth']);

});

Route::controller(\App\Http\Controllers\AttController::class)->group(function () {
    Route::get('/att/', 'index'); //->middleware(['auth']);


});
