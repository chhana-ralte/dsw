<?php

use App\Http\Controllers\WardenController;

Route::controller(WardenController::class)->group(function () {
    Route::post('/xx/warden/removeUser', 'removeUser');
    Route::get('/diktei/course', 'course')->middleware(['auth']);
    Route::get('/diktei/course/{id}', 'course_show');
    Route::get('/diktei/entry', 'entry');
    Route::get('/diktei/option', 'option');
    Route::get('/diktei/no-submission', 'no_submission');
    Route::get('/diktei/partial-submission', 'partial_submission');

    Route::post('/diktei/submit', 'submit');
    Route::get('/diktei/dtallot', 'subject_allotments');
    Route::post('/diktei/dtallot', 'allot_subjects');
    Route::post('/diktei/clearOptions', 'clear_options');
});
