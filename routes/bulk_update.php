<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BulkupdateController;

Route::controller(BulkupdateController::class)->group(function () {
    Route::post('/bulkupdate/link', 'link')->middleware(['auth', 'admin']);
    Route::post('/bulkupdate/bulkupdate', 'bulkUpdate')->middleware(['auth', 'admin']);
    Route::post('/bulkupdate/admissionUpdate', 'admissionUpdate')->middleware(['auth', 'admin']);
    Route::get('/bulkupdate', 'index')->middleware(['auth', 'admin']);
    Route::get('/bulkupdate/{id}', 'show')->middleware(['auth', 'admin']);
    Route::get('/bulkupdate/{id}/search', 'search')->middleware(['auth', 'admin']);
});
