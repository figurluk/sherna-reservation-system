<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 21/02/2017
 * Time: 17:58
 */

Route::group(['before' => 'force.ssl', 'middleware' => ['auth', 'admin']], function () {
	
	Route::get('/home', 'Admin\AdminController@index');
	Route::get('/sumernote/getImage/{name}', 'Admin\AdminController@getImage');
	Route::post('/sumernote/saveImage', 'Admin\AdminController@saveImage');
	
	Route::post('/links/available', 'Admin\AdminController@links');
	
	Route::group(['prefix' => 'reservations'], function () {
		Route::get('/', 'Admin\ReservationsController@index');
		Route::get('/create', 'Admin\ReservationsController@create');
		Route::get('/edit/{id}', 'Admin\ReservationsController@edit');
		Route::post('/store', 'Admin\ReservationsController@store');
		Route::post('/update/{id}', 'Admin\ReservationsController@update');
		Route::get('/delete/{id}', 'Admin\ReservationsController@delete');
		Route::get('/cancel/{id}', 'Admin\ReservationsController@cancel');
	});
	
	Route::group(['prefix' => 'pages'], function () {
		Route::get('/', 'Admin\PagesController@index');
//    Route::get('/create', 'Admin\PagesController@create');
		Route::get('/edit/{id}', 'Admin\PagesController@edit');
		Route::get('/visible/{id}', 'Admin\PagesController@visible');
		Route::get('/unvisible/{id}', 'Admin\PagesController@unvisible');
//    Route::post('/store', 'Admin\PagesController@store');
		Route::post('/update/{id}', 'Admin\PagesController@update');
//    Route::post('/delete/{id}', 'Admin\PagesController@delete');
	});
	
	Route::group(['prefix' => 'badges'], function () {
		Route::get('/', 'Admin\BadgesController@index');
		Route::get('/create', 'Admin\BadgesController@create');
		Route::get('/edit/{id}', 'Admin\BadgesController@edit');
		Route::post('/store', 'Admin\BadgesController@store');
		Route::post('/update/{id}', 'Admin\BadgesController@update');
		Route::post('/delete/{id}', 'Admin\BadgesController@delete');
	});
	Route::group(['prefix' => 'consoles'], function () {
		Route::get('/', 'Admin\ConsolesController@index');
		Route::get('/create', 'Admin\ConsolesController@create');
		Route::get('/edit/{id}', 'Admin\ConsolesController@edit');
		Route::post('/store', 'Admin\ConsolesController@store');
		Route::post('/update/{id}', 'Admin\ConsolesController@update');
		Route::post('/delete/{id}', 'Admin\ConsolesController@delete');
		Route::get('/type/create', 'Admin\ConsolesController@createConsoleType');
		Route::get('/type/edit/{id}', 'Admin\ConsolesController@editConsoleType');
		Route::post('/type/store', 'Admin\ConsolesController@storeConsoleType');
		Route::post('/type/update/{id}', 'Admin\ConsolesController@updateConsoleType');
	});
	Route::group(['prefix' => 'games'], function () {
		Route::get('/', 'Admin\GamesController@index');
		Route::get('/create', 'Admin\GamesController@create');
		Route::get('/edit/{id}', 'Admin\GamesController@edit');
		Route::post('/store', 'Admin\GamesController@store');
		Route::post('/update/{id}', 'Admin\GamesController@update');
		Route::post('/delete/{id}', 'Admin\GamesController@delete');
	});
	Route::group(['prefix' => 'inventory'], function () {
		Route::get('/', 'Admin\InventoryController@index');
		Route::get('/create', 'Admin\InventoryController@create');
		Route::get('/edit/{id}', 'Admin\InventoryController@edit');
		Route::post('/store', 'Admin\InventoryController@store');
		Route::post('/update/{id}', 'Admin\InventoryController@update');
		Route::post('/delete/{id}', 'Admin\InventoryController@delete');
		
		Route::get('/categories', 'Admin\InventoryController@indexCategories');
		Route::get('/categories/create', 'Admin\InventoryController@createCategories');
		Route::get('/categories/edit/{id}', 'Admin\InventoryController@editCategories');
		Route::post('/categories/store', 'Admin\InventoryController@storeCategories');
		Route::post('/categories/update/{id}', 'Admin\InventoryController@updateCategories');
		Route::post('/categories/delete/{id}', 'Admin\InventoryController@deleteCategories');
	});
	Route::group(['prefix' => 'locations'], function () {
		Route::get('/', 'Admin\LocationsController@index');
		Route::get('/create', 'Admin\LocationsController@create');
		Route::get('/edit/{id}', 'Admin\LocationsController@edit');
		Route::post('/store', 'Admin\LocationsController@store');
		Route::post('/update/{id}', 'Admin\LocationsController@update');
		Route::post('/delete/{id}', 'Admin\LocationsController@delete');
		Route::get('/status/create', 'Admin\LocationsController@createStatus');
		Route::get('/status/edit/{id}', 'Admin\LocationsController@editStatus');
		Route::post('/status/store', 'Admin\LocationsController@storeStatus');
		Route::post('/status/update/{id}', 'Admin\LocationsController@updateStatus');
	});
	
	Route::group(['prefix' => 'users'], function () {
		Route::get('/', 'Admin\UsersController@index');
		Route::get('/{userID}/badges', 'Admin\UsersController@editBadges');
		Route::get('/{userID}/ban', 'Admin\UsersController@ban');
		Route::get('/{userID}/unban', 'Admin\UsersController@unban');
		Route::get('/badges/{badgeID}/user/{userID}/remove', 'Admin\UsersController@removeBadge');
		Route::post('/{userID}/badges/add', 'Admin\UsersController@storeBadge');
		
		Route::post('/filter/email', 'Admin\UsersController@filterEmail');
		Route::post('/filter/name', 'Admin\UsersController@filterName');
		Route::post('/filter/surname', 'Admin\UsersController@filterSurname');
	});
	
	Route::group(['prefix' => 'admins'], function () {
		Route::get('/', 'Admin\AdminsController@index');
		Route::get('/create', 'Admin\AdminsController@create');
		Route::post('/store', 'Admin\AdminsController@store');
		Route::post('/delete/{id}', 'Admin\AdminsController@delete');
	});
	
	Route::group(['prefix' => 'contests'], function () {
		Route::get('/', 'Admin\ContestController@index');
		Route::get('/create', 'Admin\ContestController@create');
		Route::get('/edit/{id}', 'Admin\ContestController@edit');
		Route::post('/store', 'Admin\ContestController@store');
		Route::post('/update/{id}', 'Admin\ContestController@update');
		Route::post('/delete/{id}', 'Admin\ContestController@delete');
	});
	
	Route::group(['prefix' => 'docs'], function () {
		Route::get('/', 'Admin\DocController@index');
		Route::post('/upload', 'Admin\DocController@upload');
		Route::get('/{path}', 'Admin\DocController@delete');
	});
	
	Route::group(['prefix' => 'settings'], function () {
		Route::get('/', 'Admin\SettingsController@index');
		Route::post('/update', 'Admin\SettingsController@update');
	});
});
