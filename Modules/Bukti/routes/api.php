<?php

use Illuminate\Support\Facades\Route;
use Modules\Bukti\Http\Controllers\BuktiController;

Route::middleware(['auth'])->prefix('v1')->group(function () {
    Route::apiResource('buktis', BuktiController::class)->names('bukti');
});
