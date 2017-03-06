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

Route::get('/', 'Client\ClientController@index');

Route::get('/login', function () {
    return redirect()->action('Client\ClientController@getAuthorize');
});

Route::get('/authorize', 'Client\ClientController@getAuthorize');
Route::get('/logout', 'Client\ClientController@getLogout');


Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Admin\AdminController@index');
});

Route::get('/{code}', 'Client\ClientController@show');
