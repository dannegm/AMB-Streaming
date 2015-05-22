<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::orderBy('name', 'asc')->get();
		$data = array(
			'title' => 'Usuarios',
			'users' => $users,
		);
		return View::make('appanel/users/index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$data = array(
			'title' => 'Nuevo Usuario'
		);
		return View::make('appanel/users/create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
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


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
		$data = array(
			'title' => 'Editar Usuario',
			'user' => $user,
		);
		return View::make('appanel/users/edit', $data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
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
			if(Input::has('password')){
				$user->password = Hash::make(md5(Input::get('password')));
			}
			$user->save();

			return Redirect::to(route('appanel.user.index'));
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = User::find($id);
		if($user->rol != 1){
			$user->delete();
		}else{
			
		}

		return Redirect::route('appanel.user.index');
	}


}
