<?php

use Illuminate\Support\Facades\Route;
use Modules\Laporan\Http\Controllers\LaporanController;

Route::middleware(['web', 'auth'])->group(function () {

    // List laporan: admin sees all, user sees only their own
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::post('/laporan', [LaporanController::class, 'store']);
    Route::put('/laporan/{kode_laporan}', [LaporanController::class, 'update']); // Add this for Edit functionality

    // Admin actions (controller will enforce admin check)
    Route::patch('/laporan/{kode_laporan}/status', [LaporanController::class, 'updateStatus']);
    Route::delete('/laporan/{kode_laporan}', [LaporanController::class, 'destroy']);

});
