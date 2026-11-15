<?php

use Illuminate\Support\Facades\Route;
use Modules\Bukuphp\Http\Controllers\BukuphpController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('bukuphps', BukuphpController::class)->names('bukuphp');
});
