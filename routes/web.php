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
	Route::post('/consoles', 'Client\ClientController@postConsoles');
	Route::post('/events/create', 'Client\ClientController@postCreateEvent');
	Route::post('/events/update', 'Client\ClientController@postUpdateEvent');
	Route::post('/events/delete', 'Client\ClientController@postDeleteEvent');
	Route::get('/event/{event}/delete', 'Client\ClientController@getDeleteEvent');
	Route::post('/event', 'Client\ClientController@postEvent');
	
	Route::post('/reservation/check', 'API\APIController@checkReservation');
	
	Route::get('/uzivatel/rezervace', 'Client\ClientController@getReservations');
	Route::get('/uzivatel/odznaky', 'Client\ClientController@getBadges');
	
	Route::get('/lang/{code}', 'Client\ClientController@changeLang');
	Route::get('/{code}', 'Client\ClientController@show');
});

Route::group(['before' => 'force.ssl', 'domain' => 'api.sherna.siliconhill.cz'], function () {
	Route::post('/', 'API\APIController@checkReservation');
	Route::post('/reservation/check', 'API\APIController@checkReservation');
});

Route::group(['before' => 'force.ssl', 'domain' => 'api.sherna.sh.cvut.cz'], function () {
	Route::post('/', 'API\APIController@checkReservation');
	Route::post('/reservation/check', 'API\APIController@checkReservation');
});
