<?php

use Illuminate\Support\Facades\Route;
use Modules\Peminjaman\Http\Controllers\PeminjamanController;

Route::middleware(['web', 'auth'])->group(function () {
    // 1. Rute kustom tambahan (jika ada, letakkan di atas resource)
    Route::get('peminjaman/data', [PeminjamanController::class, 'getData'])->name('peminjaman.data');

    // 2. Route resource sudah otomatis mencakup: index, store, edit, update, dan destroy
    Route::resource('peminjaman', PeminjamanController::class);
});