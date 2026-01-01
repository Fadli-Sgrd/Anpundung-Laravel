<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\KontakController;
use App\Http\Controllers\Api\RegisterController;

// 1. Rute Public (Bisa diakses siapa saja)
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/berita', [BeritaController::class, 'index']); 
    Route::get('/berita/{key}', [BeritaController::class, 'show']);
    Route::post('/kontak', [KontakController::class, 'store']);
 
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