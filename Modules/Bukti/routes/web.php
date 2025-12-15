<?php

use Illuminate\Support\Facades\Route;
use Modules\Bukti\Http\Controllers\BuktiController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/buktis/create', fn() => view('bukti::create'));
    Route::post('/buktis', [BuktiController::class, 'store']);
});
