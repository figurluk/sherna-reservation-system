<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 21/02/2017
 * Time: 17:58
 */

Route::get('/', 'Admin\AdminController@index');

Route::group(['prefix' => 'reservations'], function () {
    Route::get('/', 'Admin\ReservationsController@index');
});
Route::group(['prefix' => 'badges'], function () {
    Route::get('/', 'Admin\BadgesController@index');
});
Route::group(['prefix' => 'consoles'], function () {
    Route::get('/', 'Admin\ConsolesController@index');
});
Route::group(['prefix' => 'games'], function () {
    Route::get('/', 'Admin\GamesController@index');
});
Route::group(['prefix' => 'inventory'], function () {
    Route::get('/', 'Admin\InventoryController@index');
});
Route::group(['prefix' => 'locations'], function () {
    Route::get('/', 'Admin\LocationsController@index');
});
Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'Admin\UsersController@index');
});
Route::group(['prefix' => 'contests'], function () {
    Route::get('/', 'Admin\ContestController@index');
});