<?php

use Illuminate\Support\Facades\Route;
use Modules\Kategori\Http\Controllers\KategoriController;

Route::middleware(['auth'])->group(function () {
    Route::resource('kategoris', KategoriController::class)->names('kategori');
});
