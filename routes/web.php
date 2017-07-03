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

Route::group(['before' => 'force.ssl'], function () {
    Route::get('/', 'Client\ClientController@index');

    Route::get('/oauth', 'Client\ClientController@oAuthCallback');
    Route::get('/login', 'Client\ClientController@getAuthorize');
    Route::get('/authorize', 'Client\ClientController@getAuthorize');

    Route::get('/logout', 'Client\ClientController@getLogout');

    Route::post('/user', 'Client\ClientController@postUserData');
    Route::post('/events', 'Client\ClientController@postEvents');
    Route::post('/events/create', 'Client\ClientController@postCreateEvent');
    Route::post('/events/update', 'Client\ClientController@postUpdateEvent');
    Route::post('/events/delete', 'Client\ClientController@postDeleteEvent');


    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'Admin\AdminController@index');
    });


    Route::group(['prefix' => 'api'], function () {
        Route::post('/reservation/check', 'API\APIController@checkReservation');
    });

    Route::get('/lang/{code}', 'Client\ClientController@changeLang');
    Route::get('/{code}', 'Client\ClientController@show');
});
