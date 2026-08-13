<?php

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\QueryController;

Route::get('/query', [Querycontroller::class, 'index'])->middleware(['auth','admin']);
Route::get('/query/create', [Querycontroller::class, 'create'])->middleware(['auth','admin']);
Route::post('/query', [Querycontroller::class, 'store'])->middleware(['auth','admin']);
Route::get('/query/exec', [Querycontroller::class, 'sql'])->middleware(['auth','admin']);
Route::post('/query/exec', [Querycontroller::class, 'exec'])->middleware(['auth','admin']);
Route::get('/query/{query}', [Querycontroller::class, 'show'])->middleware(['auth','admin']);
Route::get('/query/{query}/edit', [Querycontroller::class, 'edit'])->middleware(['auth','admin']);
Route::put('/query/{query}', [Querycontroller::class, 'update'])->middleware(['auth','admin']);
Route::delete('/query/{query}', [Querycontroller::class, 'destroy'])->middleware(['auth','admin']);
// Route::get('/testing/create', [Testcontroller::class, 'create']);
// Route::post('/testing', [Testcontroller::class, 'store']);
// Route::get('/testing/{id}', [Testcontroller::class, 'show']);
// Route::get('/testing/{id}/edit', [Testcontroller::class, 'edit']);
// Route::put('/testing/{id}', [Testcontroller::class, 'update']);
// Route::delete('/testing/{id}', [Testcontroller::class, 'destroy']);
