<?php

use Illuminate\Support\Facades\Route;
use Modules\Bukuphp\Http\Controllers\BukuphpController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('bukuphps', BukuphpController::class)->names('bukuphp');
});
