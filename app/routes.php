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

Route::get('/', function()
{
	return View::make('index');
});
Route::get('preview', function() {
	return View::make('preview/index');
});

Route::get('api/v2/eventos.json', 'IndexController@eventos');

Route::get('api/v2/stream.json', 'IndexController@stream');

Route::get('api/v2/talleres.json', 'IndexController@talleres');

Route::get('api/v2/song.json', 'IndexController@song_json');
Route::get('api/v2/song.txt', 'IndexController@song_txt');

/*
	Panel de administración
*/

Route::get('appanel', array('as' => 'appanel', 'uses'=>'AppController@login'));

Route::post('appanel/dologin', 'AppController@entrar');

Route::group(array('before' => 'auth', 'prefix' => 'appanel'), function(){

	Route::get('logout', array('as' => 'logout', 'uses' => 'AppController@salir'));

	Route::get('index', array('as' => 'index', 'uses' => 'AppController@index'));


	//secciones

	Route::get('evento', array('as' => 'appanel.evento.index', 'uses' => 'EventoController@index'));
	Route::get('evento/create', array('as' => 'appanel.evento.create', 'uses' => 'EventoController@create'));
	Route::post('evento/store', array('as' => 'appanel.evento.store', 'uses' => 'EventoController@store'));
	Route::get('evento/{id}/edit', array('as' => 'appanel.evento.edit', 'uses' => 'EventoController@edit'));
	Route::put('evento/{id}/update', array('as' => 'appanel.evento.update', 'uses' => 'EventoController@update'));
	Route::get('evento/{id}/destroy', array('as' => 'appanel.evento.destroy', 'uses' => 'EventoController@destroy'));
	Route::post('evento/destacados', array('as' => 'appanel.evento.destacados', 'uses' => 'EventoController@destacados'));

	Route::get('picture', array('as' => 'appanel.picture.index', 'uses' => 'PictureController@index'));
	Route::get('picture/create', array('as' => 'appanel.picture.create', 'uses' => 'PictureController@create'));
	Route::post('picture/store', array('as' => 'appanel.picture.store', 'uses' => 'PictureController@store'));
	Route::get('picture/{id}/edit', array('as' => 'appanel.picture.edit', 'uses' => 'PictureController@edit'));
	Route::put('picture/{id}/update', array('as' => 'appanel.picture.update', 'uses' => 'PictureController@update'));
	Route::post('picture/{id}/destroy', array('as' => 'appanel.picture.destroy', 'uses' => 'PictureController@destroy'));

	Route::get('radio/edit', array('as' => 'appanel.radio.edit', 'before' => 'rol', 'uses' => 'RadioController@edit'));
	Route::put('radio/update', array('as' => 'appanel.radio.update', 'before' => 'rol', 'uses' => 'RadioController@update'));

	Route::get('taller', array('as' => 'appanel.taller.index', 'uses' => 'TallerController@index'));
	Route::get('taller/create', array('as' => 'appanel.taller.create', 'uses' => 'TallerController@create'));
	Route::post('taller/store', array('as' => 'appanel.taller.store', 'uses' => 'TallerController@store'));
	Route::get('taller/{id}/edit', array('as' => 'appanel.taller.edit', 'uses' => 'TallerController@edit'));
	Route::put('taller/{id}/update', array('as' => 'appanel.taller.update', 'uses' => 'TallerController@update'));
	Route::get('taller/{id}/destroy', array('as' => 'appanel.taller.destroy', 'uses' => 'TallerController@destroy'));
	Route::post('taller/destacados', array('as' => 'appanel.taller.destacados', 'uses' => 'TallerController@destacados'));

	Route::get('user', array('as' => 'appanel.user.index', 'uses' => 'UserController@index'));
	Route::get('user/create', array('as' => 'appanel.user.create', 'uses' => 'UserController@create'));
	Route::post('user/store', array('as' => 'appanel.user.store', 'uses' => 'UserController@store'));
	Route::get('user/{id}/edit', array('as' => 'appanel.user.edit', 'uses' => 'UserController@edit'));
	Route::put('user/{id}/update', array('as' => 'appanel.user.update', 'uses' => 'UserController@update'));
	Route::get('user/{id}/destroy', array('as' => 'appanel.user.destroy', 'uses' => 'UserController@destroy'));

	Route::get('video/edit', array('as' => 'appanel.video.edit', 'before' => 'rol', 'uses' => 'VideoController@edit'));
	Route::put('video/update', array('as' => 'appanel.video.update', 'before' => 'rol', 'uses' => 'VideoController@update'));

	//uploads

	Route::post('upload/evento/{id}', array('as'=>'upload.evento', 'uses'=>'ImageController@uploadEvento'));
	Route::post('upload/taller/{id}', array('as'=>'upload.taller', 'uses'=>'ImageController@uploadTaller'));

});