<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Modules\Kontak\Http\Controllers\KontakController;


Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin' ? redirect('/dashboard') : redirect('/home');
    }
    return redirect('/home'); // Guest goes to home
});

// Root home route accessible by anyone
Route::get('/home', [PageController::class, 'home'])->name('home');
Route::get('/edukasi', [PageController::class, 'edukasi'])->name('edukasi');
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');


// ==================== TEST EMAIL ====================
Route::get('/test-email', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('Test email berfungsi dengan baik!', function ($message) {
            $message->to('annpundung@sisteminformasikotacerdas.id')
                    ->subject('Test Email - Anpundung');
        });
        return 'Email berhasil dikirim!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::middleware('guest')->group(function () {
    // LOGIN & REGISTER
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // lupa password
    // 1. Tampilkan form lupa password
    Route::get('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

    // 2. Proses kirim link ke email
    Route::post('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // 3. Tampilkan form ganti password baru (setelah klik link di email)
    Route::get('/reset-password/{token}', [App\Http\Controllers\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');

    // 4. Proses update password baru ke database
    Route::post('/reset-password', [App\Http\Controllers\ForgotPasswordController::class, 'reset'])->name('password.update');

});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ==================== DASHBOARD ====================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('is_admin');

    // ==================== PAGE ROUTES ====================
    Route::get('/riwayat', [PageController::class, 'riwayat'])->name('riwayat');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::patch('/profile/update', [PageController::class, 'updateProfile'])->name('profile.update');


    // ==================== ADMIN NEWS ROUTES ====================
    Route::middleware('is_admin')->prefix('admin')->group(function () {
        Route::get('/berita', [NewsController::class, 'adminIndex'])->name('admin.news.index');
        Route::get('/berita/create', [NewsController::class, 'create'])->name('admin.news.create');
        Route::post('/berita', [NewsController::class, 'store'])->name('admin.news.store');
        Route::get('/berita/{id}/edit', [NewsController::class, 'edit'])->name('admin.news.edit');
        Route::put('/berita/{id}', [NewsController::class, 'update'])->name('admin.news.update');
        Route::delete('/berita/{id}', [NewsController::class, 'destroy'])->name('admin.news.destroy');

        // Pesan Kontak
        Route::get('/pesan', [KontakController::class, 'adminIndex'])->name('admin.pesan.index');
        Route::delete('/pesan/{id}', [KontakController::class, 'destroy'])->name('admin.pesan.destroy');
    });
});
