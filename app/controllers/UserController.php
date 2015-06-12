<?php

class UserController extends \BaseController {

	public function index () {
		$users = User::orderBy('name', 'asc')->get();
		$data = array(
			'title' => 'Usuarios',
			'subtitle' => 'Control de usuarios',
			'section' => 'users',
			'users' => $users
		);
		return View::make('appanel/users/index', $data);
	}

	public function create () {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->users->create) {
			$data = array(
				'title' => 'Usuarios',
				'subtitle' => 'Nuevo usuario',
				'section' => 'users'
			);
			return View::make('appanel/users/create', $data);
		} else {
			return Redirect::to(route('appanel.user.index'));
		}
	}

	public function store () {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->users->create) {
			//validation videos
			$rules = array(
				'name' => 'required',
				'username' => 'required|max:15',
				'email' => 'required|email',
				'password' => 'required',
			);

			$messages = array (
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
				$user->uid =  uniqid();
				$user->name = Input::get('name');
				$user->username = Input::get('username');
				$user->email = Input::get('email');
				$user->password = Hash::make(md5(Input::get('password')));

				$pic_avatar = Input::get('pic_avatar');
				$pic_avatar = !empty($pic_avatar) ? $pic_avatar : 'avatar';
				$user->avatar = $pic_avatar;

				// Permisos
				function get_check_value ($input) {
					$input = empty($input) ? 'off' : 'on';
					return $input != 'on' ? false : true;
				}

				$permissions = array(
					'users' => array(
						'create' => get_check_value( Input::get('permission_user_create') ),
						'edit' => get_check_value( Input::get('permission_user_edit') ),
						'delete' => get_check_value( Input::get('permission_user_delete') ),
					),
					'channels' => array(
						'create' => get_check_value( Input::get('permission_channel_create') ),
						'edit' => get_check_value( Input::get('permission_channel_edit') ),
						'delete' => get_check_value( Input::get('permission_channel_delete') ),
					),
					'events' => array(
						'create' => get_check_value( Input::get('permission_event_create') ),
						'edit' => get_check_value( Input::get('permission_event_edit') ),
						'delete' => get_check_value( Input::get('permission_event_delete') ),
					),
				);
				$user->permission = json_encode($permissions);
				// End Permisos

				$user->save();

				return Redirect::to(route('appanel.user.index'));
			}
		} else {
			return Redirect::to(route('appanel.user.index'));
		}
	}

	public function edit ($uid) {
		$user = User::where('uid', '=', $uid)->take(1)->get();
		$data = array(
			'title' => 'Usuarios',
			'subtitle' => "Editar usuario <strong>@" . $user[0]->username . "</strong>",
			'section' => 'users',
			'user' => $user[0]
		);
		return View::make('appanel/users/edit', $data);
	}

	public function update ($uid) {
		$selfuser = Auth::user();
		if ($selfuser->permissions()->users->edit || $uid == $selfuser->uid) {
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
				$users = User::where('uid', '=', $uid)->take(1)->get();
				$user = $users[0];

				$user->name = Input::get('name');
				$user->username = Input::get('username');
				$user->email = Input::get('email');

				if (Input::has('password')) {
					$user->password = Hash::make(md5(Input::get('password')));
				}

				$pic_avatar = Input::get('pic_avatar');
				$pic_avatar = !empty($pic_avatar) ? $pic_avatar : 'avatar';
				$user->avatar = $pic_avatar;

				// Permisos
				function get_check_value ($input) {
					$input = empty($input) ? 'off' : 'on';
					return $input != 'on' ? false : true;
				}

				if ($selfuser->permissions()->users->edit) {
					$permissions = array(
						'users' => array(
							'create' => get_check_value( Input::get('permission_user_create') ),
							'edit' => get_check_value( Input::get('permission_user_edit') ),
							'delete' => get_check_value( Input::get('permission_user_delete') ),
						),
						'channels' => array(
							'create' => get_check_value( Input::get('permission_channel_create') ),
							'edit' => get_check_value( Input::get('permission_channel_edit') ),
							'delete' => get_check_value( Input::get('permission_channel_delete') ),
						),
						'events' => array(
							'create' => get_check_value( Input::get('permission_event_create') ),
							'edit' => get_check_value( Input::get('permission_event_edit') ),
							'delete' => get_check_value( Input::get('permission_event_delete') ),
						),
					);
					$user->permission = json_encode($permissions);
				}
				// End Permisos

				$user->save();
				return Redirect::to(route('appanel.user.edit', array('uid' => $user->uid)));
			}
		} else {
			return Redirect::route('appanel.user.index');
		}
	}

	public function destroy ($uid) {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->users->delete) {
			$users = User::where('uid', '=', $uid)->take(1)->get();
			$user = $users[0];
			$user->delete();
		}
		return Redirect::route('appanel.user.index');
	}


}
