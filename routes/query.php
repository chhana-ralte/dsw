<?php

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\QueryController;

Route::get('/query', [Querycontroller::class, 'index']);
Route::get('/query/create', [Querycontroller::class, 'create']);
Route::post('/query/exec', [Querycontroller::class, 'exec']);
Route::get('/query/{query}', [Querycontroller::class, 'show']);
Route::get('/query/{query}/edit', [Querycontroller::class, 'edit']);
Route::put('/query/{query}', [Querycontroller::class, 'update']);
// Route::get('/testing/create', [Testcontroller::class, 'create']);
// Route::post('/testing', [Testcontroller::class, 'store']);
// Route::get('/testing/{id}', [Testcontroller::class, 'show']);
// Route::get('/testing/{id}/edit', [Testcontroller::class, 'edit']);
// Route::put('/testing/{id}', [Testcontroller::class, 'update']);
// Route::delete('/testing/{id}', [Testcontroller::class, 'destroy']);
