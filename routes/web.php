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

Route::prefix('admin')->group(function(){
   Route::get('/', 'Admin\HomeController@dashboard')->name('adminDashboard');
});

Route::prefix('settings')->group(function(){
    Route::get('/', 'Auth\AuthController@settings')->name('settings');
    Route::post('updatePersonalData', 'Auth\AuthController@updatePersonalData')->name('updatePersonalData');
    Route::post('updateAvatar', 'Auth\AuthController@updateAvatar')->name('updateAvatar');
    Route::post('updatePassword', 'Auth\AuthController@updatePassword')->name('updatePassword');
});

