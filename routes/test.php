<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::get('/testing', [Testcontroller::class, 'index']);
Route::get('/testing/create', [Testcontroller::class, 'create']);
Route::post('/testing', [Testcontroller::class, 'store']);
Route::get('/testing/{id}', [Testcontroller::class, 'show']);
Route::get('/testing/{id}/edit', [Testcontroller::class, 'edit']);
Route::put('/testing/{id}', [Testcontroller::class, 'update']);
Route::delete('/testing/{id}', [Testcontroller::class, 'destroy']);
