<?php

use App\Http\Controllers\AdmUpdateController;

Route::controller(\App\Http\Controllers\AdmUpdateController::class)->group(function () {
    Route::get('/bulk_update/', 'index')->middleware(['auth', 'admin']);
    // Route::get('/appl/courses', 'courses')->

    // Route::put('/appl/{id}/statusUpdate', 'statusUpdate')->middleware(['auth']);

    // Route::delete('/ajax/appl/{application}/delete', 'destroy')->middleware(['auth']);

    // Route::get('/appl/department/{department}', 'department')->middleware(['auth']);
    // Route::get('/appl', 'index')->middleware(['auth']);
    // Route::get('/appl/allotment_summary', 'allotment_summary')->middleware(['auth']);
    // Route::get('/appl/allotted', 'allotted')->middleware(['auth']);
    // Route::get('/appl/{application}', 'show')->middleware(['auth']);
});
