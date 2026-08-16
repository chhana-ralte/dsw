<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BulkupdateController;

Route::post('/bulkupdate/link', [BulkupdateController::class, 'link']);
Route::post('/bulkupdate/bulkupdate', [BulkupdateController::class, 'bulkUpdate']);
Route::post('/bulkupdate/admissionUpdate', [BulkupdateController::class, 'admissionUpdate']);
Route::get('/bulkupdate', [BulkupdateController::class, 'index']);
Route::get('/bulkupdate/{id}', [BulkupdateController::class, 'show']);
Route::get('/bulkupdate/{id}/search', [BulkupdateController::class, 'search']);

