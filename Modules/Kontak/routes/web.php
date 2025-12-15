<?php

use Illuminate\Support\Facades\Route;
use Modules\Kontak\Http\Controllers\KontakController;

Route::middleware(['auth'])->group(function () {
    Route::get('/kontak', [KontakController::class, 'index']);
    Route::post('/kontak', [KontakController::class, 'store']);
});
