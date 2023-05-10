<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SetupController;

/* 
|-------------
| Setup routes 
|-------------
*/
Route::group(['middleware' => ['setup.block']], function () {
    // Setup Route
    Route::group([
        'prefix' => 'setup',
        'as' => 'setup.'
    ], function () {
        Route::get('start', [SetupController::class, 'welcome'])->name('welcome');
        Route::get('requirements', [SetupController::class, 'requirements'])->name('requirements');
        Route::get('database', [SetupController::class, 'database'])->name('database');
        Route::post('database', [SetupController::class, 'configure'])->name('save-database');
        Route::get('complete', [SetupController::class, 'complete'])->name('complete');
    });
});
