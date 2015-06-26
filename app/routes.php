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

// Player
Route::get('channel/{uid}/player', array('as' => 'player.channel', 'uses' => 'PlayerController@channel'));
Route::get('event/{uid}/player', array('as' => 'player.event', 'uses' => 'PlayerController@event'));
Route::get('api/widget.js', array('uses' => 'PlayerController@widget'));

// Home
Route::get('/', array('as' => 'home.index', 'uses' => 'IndexController@index'));
Route::get('events', array('as' => 'home.events', 'uses' => 'IndexController@events'));

Route::get('channel/{uid}/{void}', array('as' => 'home.channel', 'uses' => 'IndexController@channel'));
Route::get('event/{uid}/{void}', array('as' => 'home.event', 'uses' => 'IndexController@event'));

// 404
Route::get('404', array('as' => 'home.e404', 'uses' => 'IndexController@e404'));

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
	Route::post('picture/upload', array('as' => 'appanel.picture.upload', 'uses'=>'ImageController@upload'));
	Route::get('pictures/{group}.json', array('uses'=>'ImageController@list_json'));

	// Channels
	Route::get('channels', array('as' => 'appanel.channels.index', 'uses' => 'ChannelsController@index'));
	Route::get('channels/{uid}/view', array('as' => 'appanel.channels.view', 'uses' => 'ChannelsController@view'));
	Route::get('channels/create', array('as' => 'appanel.channels.create', 'uses' => 'ChannelsController@create'));
	Route::post('channels/store', array('as' => 'appanel.channels.store', 'uses' => 'ChannelsController@store'));
	Route::get('channels/{uid}/edit', array('as' => 'appanel.channels.edit', 'uses' => 'ChannelsController@edit'));
	Route::put('channels/{uid}/update', array('as' => 'appanel.channels.update', 'uses' => 'ChannelsController@update'));
	Route::get('channels/{uid}/delete', array('as' => 'appanel.channels.delete', 'uses' => 'ChannelsController@delete'));
	Route::get('channels/{uid}/put/online', array('as' => 'appanel.channels.put.online', 'uses' => 'ChannelsController@setOnline'));
	Route::get('channels/{uid}/put/offline', array('as' => 'appanel.channels.put.offline', 'uses' => 'ChannelsController@setOffline'));

	// Events
	Route::get('events', array('as' => 'appanel.events.index', 'uses' => 'EventsController@index'));
	Route::get('events/{uid}/view', array('as' => 'appanel.events.view', 'uses' => 'EventsController@view'));
	Route::get('events/create', array('as' => 'appanel.events.create', 'uses' => 'EventsController@create'));
	Route::post('events/store', array('as' => 'appanel.events.store', 'uses' => 'EventsController@store'));
	Route::get('events/{uid}/edit', array('as' => 'appanel.events.edit', 'uses' => 'EventsController@edit'));
	Route::put('events/{uid}/update', array('as' => 'appanel.events.update', 'uses' => 'EventsController@update'));
	Route::get('events/{uid}/delete', array('as' => 'appanel.events.delete', 'uses' => 'EventsController@delete'));

	Route::get('events/{uid}/addhour', array('as' => 'appanel.events.addhour', 'uses' => 'EventsController@addHour'));
	Route::get('events/{uid}/finish', array('as' => 'appanel.events.finish', 'uses' => 'EventsController@finish'));

});

App::error(function (Exception $exception) {
    return Redirect::to(route('home.e404'));
});
