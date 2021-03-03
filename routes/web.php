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
Route::patch('/campaigns-status/{campaigns}/{status}', [CampaignsController::class, 'status'])->name('admin.campaigns.status');
Route::get('/campaigns-active', [CampaignsController::class, 'active'])->name('admin.campaigns.active');
Route::get('/campaigns-archive', [CampaignsController::class, 'archive'])->name('admin.campaigns.archive');
 Route::get('/campaigns', [CampaignsController::class, 'index'])->name('admin.campaigns.index');
 Route::get('/donations/{id}', [DonationsController::class, 'show'])->name('admin.donations.show');
});
