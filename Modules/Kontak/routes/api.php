<?php

use Illuminate\Support\Facades\Route;
use Modules\Kontak\Http\Controllers\KontakController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('kontaks', KontakController::class)->names('kontak');
});
