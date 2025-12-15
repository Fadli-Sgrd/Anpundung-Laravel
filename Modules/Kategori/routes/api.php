<?php

use Illuminate\Support\Facades\Route;
use Modules\Kategori\Http\Controllers\KategoriController;

Route::middleware(['auth'])->prefix('v1')->group(function () {
    Route::apiResource('kategoris', KategoriController::class)->names('kategori');
});
