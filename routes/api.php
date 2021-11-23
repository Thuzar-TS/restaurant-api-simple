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

// for api version 1
Route::prefix('v1')->group(function(){
    Route::get('/restaurants', 'V1\RestaurantController@list');
    Route::get('/restaurants/{restaurantId}', 'V1\RestaurantController@getRestaurant');
    Route::post('/restaurants', 'V1\RestaurantController@createRestaurant');
    Route::put('/restaurants/{restaurantId}', 'V1\RestaurantController@updateRestaurant');
    Route::delete('/restaurants/{restaurantId}', 'V1\RestaurantController@deleteRestaurant');
});
