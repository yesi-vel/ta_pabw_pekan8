<?php

use Illuminate\Support\Facades\Route;
use Modules\Artisan\Http\Controllers\ArtisanController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('artisans', ArtisanController::class)->names('artisan');
});
