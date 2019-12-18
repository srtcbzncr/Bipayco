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

Route::prefix('category')->group(function(){
    Route::get('index', 'API\GeneralEducation\CategoryController@index')->name('api_category_index');
    Route::get('{id}', 'API\GeneralEducation\CategoryController@show')->name('api_category_show');
});

Route::prefix('courses')->group(function(){
    Route::get('{category_id}/getByCategoryFilterByNewest', 'API\GeneralEducation\CourseController@getByCategoryFilterByNewest')->name('api_course_get_by_category_filter_by_newest');
    Route::get('{category_id}/getByCategoryFilterByOldest', 'API\GeneralEducation\CourseController@getByCategoryFilterByOldest')->name('api_course_get_by_category_filter_by_oldest');
    Route::get('{category_id}/getByCategoryFilterByPriceASC', 'API\GeneralEducation\CourseController@getByCategoryFilterByPriceASC')->name('api_course_get_by_category_filter_by_price_asc');
    Route::get('{category_id}/getByCategoryFilterByPriceDESC', 'API\GeneralEducation\CourseController@getByCategoryFilterByPriceDESC')->name('api_course_get_by_category_filter_by_price_desc');
    Route::get('{category_id}/getByCategoryFilterByPoint', 'API\GeneralEducation\CourseController@getByCategoryFilterByPoint')->name('api_course_get_by_category_filter_by_point');
    Route::get('{category_id}/getByCategoryFilterByPurchases', 'API\GeneralEducation\CourseController@getByCategoryFilterByPurchases')->name('api_course_get_by_category_filter_by_purchases');
    Route::get('{category_id}/getByCategoryFilterByTrending', 'API\GeneralEducation\CourseController@getByCategoryFilterByTrending')->name('api_course_get_by_category_filter_by_trending');
    Route::get('{sub_category_id}/getBySubCategoryFilterByNewest', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByNewest')->name('api_course_get_by_sub_category_filter_by_newest');
    Route::get('{sub_category_id}/getBySubCategoryFilterByOldest', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByOldest')->name('api_course_get_by_sub_category_filter_by_oldest');
    Route::get('{sub_category_id}/getBySubCategoryFilterByPriceASC', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByPriceASC')->name('api_course_get_by_sub_category_filter_by_price_asc');
    Route::get('{sub_category_id}/getBySubCategoryFilterByPriceDESC', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByPriceDESC')->name('api_course_get_by_sub_category_filter_by_price_desc');
    Route::get('{sub_category_id}/getBySubCategoryFilterByPoint', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByPoint')->name('api_course_get_by_sub_category_filter_by_point');
    Route::get('{sub_category_id}/getBySubCategoryFilterByPurchases', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByPurchases')->name('api_course_get_by_sub_category_filter_by_purchases');
    Route::get('{sub_category_id}/getBySubCategoryFilterByTrending', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByTrending')->name('api_course_get_by_sub_category_filter_by_trending');
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
