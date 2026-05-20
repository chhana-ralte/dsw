<?php
use App\Http\Controllers\diktei\ZirlaiController;
use App\Http\Controllers\DikteiController;

Route::controller(DikteiController::class)->group(function () {
    Route::get('/diktei/', 'index');
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
