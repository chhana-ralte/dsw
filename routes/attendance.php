<?php

use App\Http\Controllers\AttController;
use App\Http\Controllers\EnrollController;
use App\Http\Controllers\AttmasterController;
use App\Http\Controllers\StdController;

Route::controller(AttmasterController::class)->group(function () {
    Route::get('/att/', 'index'); //->middleware(['auth']);
    Route::get('/att/attmaster/create', 'create'); //->middleware(['auth']);
    Route::get('/att/attmaster/{attmaster}', 'show'); //->middleware(['auth']);
    Route::post('/att/attmaster/', 'store'); //->middleware(['auth']);
});

Route::controller(AttController::class)->group(function () {
    //Route::get('/att/', 'index'); //->middleware(['auth']);
    Route::get('/att/attmaster/{attmaster}/take', 'take'); //->middleware(['auth']);
    Route::post('/att/attmaster/{attmaster}/take', 'store'); //->middleware(['auth']);
    Route::get('/att/attmaster/{attmaster}/show', 'show'); //->middleware(['auth']);
});

Route::controller(EnrollController::class)->group(function () {
    //Route::get('/att/', 'index'); //->middleware(['auth']);
    Route::get('/att/course/{course}/sessn/{sessn}/enroll/{semester?}', 'index');
    Route::post('/att/course/{course}/sessn/{sessn}/enroll/{semester?}', 'tmp_store');
    Route::post('/att/course/{course}/sessn/{sessn}/enroll_store/{semester?}', 'store');
});

Route::controller(StdController::class)->group(function () {
    // Route::get('/att/', 'index'); //->middleware(['auth']);
    // Route::get('/att/course/{course}', 'index');
});
