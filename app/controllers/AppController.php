<?php

class AppController extends Controller {

	public function login () {
		if (Auth::check()) {
			return Redirect::to(route('index'));
		} else {
			$data = array (
				'title' => 'Login',
			);
			return View::make('appanel/login', $data);
		}
	}

	public function entrar () {
		$username = Input::get('username');
		$password = Input::get('password');
		$_token = Input::get('_token');

		$attempt = Auth::attempt(array(
			'username' => $username,
			'password' => md5($password)
		));
		if ($attempt) {
			return Redirect::to('appanel/index');
			// Log: Auth::id();
		} else {
			return Redirect::route('appanel')
				->withErrors(array('La contraseña o el password son incorrectos'))
				->withInput();
		}
	}

	public function salir () {
		Auth::logout();
		return Redirect::to('appanel');
	}

	public function index () {
		if (Auth::check()) {
			$data = array(
				'title' => 'Inicio',
			);
			return View::make('appanel/index', $data);
		} else {
			return Redirect::to('appanel');
		}
	}
}