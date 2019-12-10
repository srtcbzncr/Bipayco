<?php

use Illuminate\Http\Request;

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

Route::prefix('country')->group(function(){
    Route::get('index', 'API\Base\CountryController@index')->name('api_country_index');
    Route::get('{id}', 'API\Base\CountryController@show')->name('api_country_show');
    Route::get('{id}/cities', 'API\Base\CountryController@cities')->name('api_country_cities');
});

Route::prefix('city')->group(function(){
    Route::get('index', 'API\Base\CityController@index')->name('api_city_index');
    Route::get('{id}', 'API\Base\CityController@show')->name('api_city_show');
    Route::get('{id}/districts', 'API\Base\CityController@districts')->name('api_city_districts');
});

Route::prefix('district')->group(function(){
    Route::get('index', 'API\Base\DistrictController@index')->name('api_district_index');
    Route::get('{id}', 'API\Base\DistrictController@show')->name('api_district_show');
});
