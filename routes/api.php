<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('api-user-registration','Api\ApiFunctionCallController@ApiUserregistration');
Route::post('api-user-login','Api\ApiFunctionCallController@login');
Route::post('api-user-logout','Api\ApiFunctionCallController@logout');

Route::get('api-user-me','Api\ApiFunctionCallController@me');