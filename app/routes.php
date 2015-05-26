<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function() {
	return View::make('index');
});
Route::get('preview', function() {
	return View::make('preview/index');
});

/*
	Panel de administración
*/
	Route::post('picture/upload', array('uses'=>'ImageController@upload'));

// App
Route::get('appanel', array('as' => 'appanel', 'uses'=>'AppController@login'));
Route::post('appanel/dologin', 'AppController@entrar');

Route::group(array('before' => 'auth', 'prefix' => 'appanel'), function() {
	// App
	Route::get('logout', array('as' => 'logout', 'uses' => 'AppController@salir'));
	Route::get('index', array('as' => 'index', 'uses' => 'AppController@index'));

	// Users
	Route::get('user', array('as' => 'appanel.user.index', 'uses' => 'UserController@index'));
	Route::get('user/create', array('as' => 'appanel.user.create', 'uses' => 'UserController@create'));
	Route::post('user/store', array('as' => 'appanel.user.store', 'uses' => 'UserController@store'));
	Route::get('user/{id}/edit', array('as' => 'appanel.user.edit', 'uses' => 'UserController@edit'));
	Route::put('user/{id}/update', array('as' => 'appanel.user.update', 'uses' => 'UserController@update'));
	Route::get('user/{id}/destroy', array('as' => 'appanel.user.destroy', 'uses' => 'UserController@destroy'));

	// Pictures
	Route::post('picture/upload', array('uses'=>'ImageController@upload'));
	Route::get('pictures/{group}.json', array('uses'=>'ImageController@list_json'));

	// Channels
	Route::get('channels', array('as' => 'appanel.channels.index', 'uses' => 'ChannelsController@index'));
	Route::get('channels/create', array('as' => 'appanel.channels.create', 'uses' => 'ChannelsController@create'));
	Route::post('channels/store', array('as' => 'appanel.channels.store', 'uses' => 'ChannelsController@store'));

	// Events
	Route::get('events', array('as' => 'appanel.events.index', 'uses' => 'EventsController@index'));
	Route::get('events/create', array('as' => 'appanel.events.create', 'uses' => 'EventsController@create'));
	Route::post('events/store', array('as' => 'appanel.events.store', 'uses' => 'EventsController@store'));

});