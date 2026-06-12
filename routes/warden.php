<?php

use App\Http\Controllers\WardenController;

Route::controller(WardenController::class)->group(function () {
    Route::post('/xx/warden/removeUser', 'removeUser');
});
