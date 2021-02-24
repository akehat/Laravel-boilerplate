<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\DonationsController;

// use App\Models\Campaigns;

/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LocaleController::class, 'change'])->name('locale.change');

/*
 * Frontend Routes
 */
Route::group(['as' => 'frontend.'], function () {
    includeRouteFiles(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 *
 * These routes can only be accessed by users with type `admin`
 */
 Route::get('/clear-config', function () {
    $exitCode = Artisan::call('config:cache');
    return 'Application cache cleared';
});
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    includeRouteFiles(__DIR__.'/backend/');
    
});
Route::group(['middleware' => ['auth']], function() {
   
 Route::get('/campaigns', [CampaignsController::class, 'index'])->name('admin.campaigns.index');
 Route::get('/donations', [DonationsController::class, 'index'])->name('admin.donations.index');
});


// Route::get('/campaigns/{id}', [CampaignsController::class, 'edit'])->name('admin.auth.campaigns.edit');
// Route::post('/campaigns/{id}',[CampaignsController::class, 'campaigns'])->name('admin.auth.campaigns.update');
// Route::delete('/campaigns', [CampaignsController::class, 'destroy'])->name('admin.auth.campaigns.destroy');

// Route::get('campaigns', [CampaignsController::class, 'index']);