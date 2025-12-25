<?php

use Illuminate\Support\Facades\Route;
use HopekellDev\Core\Installer\Http\Controllers\InstallController;

// Apply 'web' middleware group to all installer routes
Route::middleware('web')->group(function () {

    // Step 1: License / initial installer page
    Route::get('/install', [InstallController::class, 'step1'])
        ->name('hopekell.install');

    Route::get('/install/verify-purchase-code', [InstallController::class, 'step2'])
        ->name('hopekell.install.step2');

    // Step 2: Verify purchase / license code
    Route::post('/install/verify-purchase-code', [InstallController::class, 'verify'])
        ->name('hopekell.install.verify');

    // Step 3: Submit database credentials
    Route::get('/install/database', [InstallController::class, 'databaseForm'])
        ->name('hopekell.install.database.form');

    Route::post('/install/database', [InstallController::class, 'database'])
        ->name('hopekell.install.database');

    // Step 3: Submit database credentials
    Route::get('/install/database/import-sql', [InstallController::class, 'databaseImportSql'])
        ->name('hopekell.install.database.import-sql');

    Route::post('/install/database/import-sql', [InstallController::class, 'importSql'])
        ->name('hopekell.install.database.import-sql.post');

    // Installation success page
    Route::get('/install/success', [InstallController::class, 'success'])
        ->name('hopekell.install.success');
});
