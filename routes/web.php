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

//Route::get('/', function () {
//    return view('home');
//});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/download', 'HomeController@download')->name('download');
Route::get('/create_link', 'HomeController@createLink')->name('create_link');
Route::get('/getCampaigns', 'HomeController@getCampaigns')->name('get_link');
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::post('/update', 'HomeController@update')->name('update');
Route::post('/saveCampaign','HomeController@saveCampaign')->name('save_campaign');
