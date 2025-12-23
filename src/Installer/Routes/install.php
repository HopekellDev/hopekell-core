<?php

use Illuminate\Support\Facades\Route;
use HopekellDev\Core\Installer\Http\Controllers\InstallController;

// Apply 'web' middleware group to all installer routes
Route::middleware('web')->group(function () {

    // Step 1: License / initial installer page
    Route::get('/install', [InstallController::class, 'step1'])
        ->name('hopekell.install');

    // Step 2: Verify purchase / license code
    Route::post('/install/verify', [InstallController::class, 'verify'])
        ->name('hopekell.install.verify');

    // Step 3: Submit database credentials
    Route::post('/install/database', [InstallController::class, 'database'])
        ->name('hopekell.install.database');

    // Installation success page
    Route::get('/install/success', [InstallController::class, 'success'])
        ->name('hopekell.install.success');
});
