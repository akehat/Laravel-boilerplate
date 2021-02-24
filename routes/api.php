<?php

use Illuminate\Http\Request;
use App\Models\Campaigns;
use App\Http\Controllers\Api\ApiCampaignsController;
use App\Http\Controllers\Api\CampaignsController;
use App\Http\Controllers\Api\DonationsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::apiResource('donations', DonationsController::class);
Route::apiResource('campaigns', CampaignsController::class);
// Route::apiResource('campaigns', [ApiCampaignsController::class, 'index']);
// Route::get('campaigns/{id}', [ApiCampaignsController::class, 'show']);
// Route::post('campaigns', [ApiCampaignsController::class, 'store']);
// Route::put('campaigns/{id}', [ApiCampaignsController::class, 'index']);
// Route::get('get_campaigns', [ApiCampaignsController::class, 'index']);

// Route::get('get_campaigns', 'Api\ApiCampaignsController@index');
// Route::get('campaigns/{id}', 'ArticleController@show');
// Route::post('campaigns', 'ArticleController@store');
// Route::put('campaigns/{id}', 'ArticleController@update');
// Route::delete('campaigns/{id}', 'ArticleController@delete');

// Route::get('get_campaigns', function() {
//     // If the Content-Type and Accept headers are set to 'application/json', 
//     // this will return a JSON structure. This will be cleaned up later.
//     return Campaigns::all();
// });
