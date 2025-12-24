<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

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
    Route::get('/riwayat', [PageController::class, 'riwayat'])->name('riwayat');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::patch('/profile/update', [PageController::class, 'updateProfile'])->name('profile.update');
    Route::get('/edukasi', [PageController::class, 'edukasi'])->name('edukasi');
    Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
    Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

    // ==================== ADMIN NEWS ROUTES ====================
    Route::middleware('is_admin')->prefix('admin')->group(function () {
        Route::get('/berita', [NewsController::class, 'adminIndex'])->name('admin.news.index');
        Route::get('/berita/create', [NewsController::class, 'create'])->name('admin.news.create');
        Route::post('/berita', [NewsController::class, 'store'])->name('admin.news.store');
        Route::get('/berita/{id}/edit', [NewsController::class, 'edit'])->name('admin.news.edit');
        Route::put('/berita/{id}', [NewsController::class, 'update'])->name('admin.news.update');
        Route::delete('/berita/{id}', [NewsController::class, 'destroy'])->name('admin.news.destroy');
    });
});
