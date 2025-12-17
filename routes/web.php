<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

// ==================== AUTH ROUTES ====================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // ==================== DASHBOARD ====================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ==================== PAGE ROUTES ====================
    Route::get('/home', [PageController::class, 'home'])->name('home');
    Route::redirect('/edukasi', '/home'); // Edukasi content merged into home
    Route::get('/berita', [PageController::class, 'berita'])->name('berita');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::patch('/profile/update', [PageController::class, 'updateProfile'])->name('profile.update');
    Route::get('/edukasi', function () {
        return view('pages.edukasi');
    })->name('edukasi');
});

