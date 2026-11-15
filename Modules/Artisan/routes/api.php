<?php

use Illuminate\Support\Facades\Route;
use Modules\Artisan\Http\Controllers\ArtisanController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('artisans', ArtisanController::class)->names('artisan');
});
