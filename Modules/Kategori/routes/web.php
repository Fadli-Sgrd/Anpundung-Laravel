<?php

use Illuminate\Support\Facades\Route;
use Modules\Kategori\Http\Controllers\KategoriController;

// Group route dengan middleware auth (hanya user login bisa akses)
Route::middleware(['auth'])->group(function () {
    Route::resource('kategoris', KategoriController::class);
});