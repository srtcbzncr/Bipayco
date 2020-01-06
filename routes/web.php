<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('register', 'Auth\AuthController@registerGet')->name('registerGet');
Route::post('register', 'Auth\AuthController@registerPost')->name('registerPost');
Route::get('login', 'Auth\AuthController@loginGet')->name('loginGet');
Route::post('login', 'Auth\AuthController@loginPost')->name('loginPost');
Route::get('logout', 'Auth\AuthController@logout')->name('logout');
Route::get('error', 'HomeController@error')->name('error');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
   Route::get('/', 'Admin\HomeController@dashboard')->name('adminDashboard');
});

Route::group(['prefix' => 'settings', 'middleware' => 'auth'], function(){
    Route::get('/', 'Auth\AuthController@settings')->name('settings');
    Route::post('updatePersonalData', 'Auth\AuthController@updatePersonalData')->name('updatePersonalData');
    Route::post('updateAvatar', 'Auth\AuthController@updateAvatar')->name('updateAvatar');
    Route::post('updatePassword', 'Auth\AuthController@updatePassword')->name('updatePassword');
    Route::post('updateInstructorData', 'Auth\AuthController@updateInstructorData')->name('updateInstructorData');
});

Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function(){
    Route::get('student/{id}', 'Auth\AuthController@studentProfile')->name('student_profile');
    Route::get('instructor/{id}', 'Auth\AuthController@instructorProfile')->name('instructor_profile');
});

Route::group(['prefix' => 'ge'], function(){
    Route::group(['prefix' => 'category'], function(){
        Route::get('{id}', 'GeneralEducation\CategoryController@show')->name('ge_category_courses');
    });
    Route::group(['prefix' => 'subCategory'], function(){
        Route::get('{id}', 'GeneralEducation\SubCategoryController@show')->name('ge_sub_category_courses');
    });
    Route::group(['prefix' => 'course'], function(){
        Route::get('{id}', 'GeneralEducation\CourseController@show')->name('ge_course');
        Route::get('{id}/watch', 'GeneralEduation\CourseController@watch')->name('ge_watch');
    });
    Route::get('index', 'HomeController@ge_index')->name('ge_index');
});




