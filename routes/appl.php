<?php

use App\Http\Controllers\ApplController;

Route::controller(\App\Http\Controllers\ApplController::class)->group(function () {
    Route::get('/appl','index')->middleware(['auth']);
    Route::get('/appl/department/{department}','department')->middleware(['auth']);
});
