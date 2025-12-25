<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\ProfileController;

// 1. Rute Public (Bisa diakses siapa saja)
Route::post('/login', [LoginController::class, 'login']);

// 2. Rute Private (Harus Login dulu, dijaga Middleware ApiAuth)
// Pastikan nama middleware 'api_auth' sudah didaftarkan ya!
 
Route::middleware(['api_auth'])->group(function () {
    
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::post('/laporan', [LaporanController::class, 'store']);
    Route::get('/laporan/{id}', [LaporanController::class, 'show']);
    Route::delete('/laporan/{id}', [LaporanController::class, 'destroy']);
    Route::put('/laporan/{id}', [LaporanController::class, 'update']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::post('/logout', [LoginController::class, 'logout']);
    
});