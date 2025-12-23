<?php

use Illuminate\Support\Facades\Route;
use HopekellDev\Core\Installer\Http\Controllers\InstallController;

Route::middleware('web')->group(function () {
    Route::get('/install', [InstallController::class, 'step1'])
        ->name('hopekell.install');

    Route::post('/install/verify', [InstallController::class, 'verify']);
    Route::post('/install/database', [InstallController::class, 'database']);
    Route::get('/install/success', [InstallController::class, 'success']);
});
