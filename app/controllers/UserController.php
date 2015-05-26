<?php

class UserController extends \BaseController {

	public function index() {
		$users = User::orderBy('name', 'asc')->get();
		$data = array(
			'title' => 'Usuarios',
			'subtitle' => 'Control de usuarios',
			'section' => 'users',
			'users' => $users
		);
		return View::make('appanel/users/index', $data);
	}

	public function create() {
		$data = array(
			'title' => 'Usuarios',
			'subtitle' => 'Nuevo usuario',
			'section' => 'users'
		);
		return View::make('appanel/users/create', $data);
	}

	public function store() {
		//validation videos
		$rules = array(
			'name' => 'required',
			'username' => 'required|max:15',
			'email' => 'required|email',
			'password' => 'required',
		);

		$messages = array(
			'name.required' => 'El nombre es necesario',
			'username.required' => 'Es necesrio colocar un username',
			'email.required' => 'El email es obligatorio',
			'email.email' => 'No colocaste un email válido',
			'password.required' => 'Es obligatorio colocar una contraseña',
			'username.max' => 'El username no puede sobrepasar 15 caracteres'
		);

		//check validation
		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
			$messages = $validator->messages();
			return Redirect::route('appanel.user.create')
				->withErrors($validator)
				->withInput();
		} else {
			$user = new User;
			$user->name = Input::get('name');
			$user->username = Input::get('username');
			$user->email = Input::get('email');
			$user->rol = 2;
			$user->password = Hash::make(md5(Input::get('password')));
			$user->save();

			return Redirect::to(route('appanel.user.index'));
		}
	}

	public function edit($id) {
		$user = User::find($id);
		$data = array(
			'title' => 'Usuarios',
			'subtitle' => "Editar usuario <strong>@" . $user->username . "</strong>",
			'section' => 'users',
			'user' => $user
		);
		return View::make('appanel/users/edit', $data);
	}

	public function update($id) {
		//validation videos
		$rules = array(
			'name' => 'required',
			'username' => 'required',
			'email' => 'required|email',
		);
		$messages = array(
			'name.required' => 'El nombre es necesario',
			'username.required' => 'Es necesrio colocar un username',
			'email.required' => 'El email es obligatorio',
			'email.email' => 'No colocaste un email válido'
		);

		//check validation
		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
			$messages = $validator->messages();
			return Redirect::route('appanel.user.edit', array('id'=>$id))
				->withErrors($validator)
				->withInput();
		} else {
			$user = User::find($id);
			$user->name = Input::get('name');
			$user->username = Input::get('username');
			$user->email = Input::get('email');
			if (Input::has('password')) {
				$user->password = Hash::make(md5(Input::get('password')));
			}
			$user->save();
			return Redirect::to(route('appanel.user.index'));
		}
	}

	public function destroy($id) {
		$user = User::find($id);
		if ($user->rol != 1) {
			$user->delete();
		} else {
		}
		return Redirect::route('appanel.user.index');
	}


}
