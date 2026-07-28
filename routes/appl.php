<?php

use App\Http\Controllers\ApplController;

Route::controller(\App\Http\Controllers\ApplController::class)->group(function () {
    // Route::get('/appl/courses', 'courses')->
    Route::get('/appl', 'index')->middleware(['auth']);
    Route::put('/appl/{application}/statusUpdate', 'statusUpdate')->middleware(['auth']);
    Route::get('/appl/{application}', 'show')->middleware(['auth']);
    Route::delete('/ajax/appl/{application}/delete', 'destroy')->middleware(['auth']);
    Route::get('/appl/department/{department}', 'department')->middleware(['auth']);
});
