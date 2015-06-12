<?php

class ChannelsController extends \BaseController {

	/**
	Views
	*/
	public function index () {
		$channels = Channel::orderBy('id', 'desc')->get();
		$data = array (
			'title' => 'Canales',
			'subtitle' => 'Todos los canales',
			'section' => 'channels',
			'channels' => $channels
		);
		return View::make('appanel/channels/index', $data);
	}
	public function create () {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->channels->create) {
			$data = array(
				'title' => 'Canales',
				'subtitle' => 'Nuevo canal',
				'section' => 'channels'
			);
			return View::make('appanel/channels/create', $data);
		} else {
			return Redirect::to(route('appanel.channels.index'));
		}
	}

	public function delete ($uid) {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->channels->delete) {
			$channel = Channel::where('uid', '=', $uid)->take(1)->get();
			$channel[0]->delete();
		}
		return Redirect::to(route('appanel.channels.index'));
	}

	public function view ($uid) {
		$channel = Channel::where('uid', '=', $uid)->take(1)->get();
		$data = array(
			'title' => 'Canales',
			'subtitle' => "Información",
			'section' => 'channels',
			'channel' => $channel[0]
		);
		return View::make('appanel/channels/view', $data);
	}

	// Store
	public function store () {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->channels->create) {
			//validation videos
			$rules = array (
				'name' => 'required',
				'description' => 'required',
				'rtmp' => array('required',
					'regex:/^rtmp\:\/\/(|[a-z0-9]{3,}\.)[a-z0-9]{3,}\.[a-z]{2,5}(|\:[0-9]{1,5})\/(.+)$/')
			);

			$messages = array (
				'name.required' => 'El nombre es necesario',
				'description.required' => 'Es necesrio colocar descripción',
				'rtmp.required' => 'Es necesario colocar un canal RTMP',
				'rtmp.regex' => 'El RTMP no es válido'
			);

			//check validation
			$validator = Validator::make(Input::all(), $rules, $messages);

			if ($validator->fails()) {
				$messages = $validator->messages();
				return Redirect::route('appanel.channels.create')
					->withErrors($validator)
					->withInput();
			} else {
				$channel = new Channel;

				$channel->uid =  uniqid();
				$channel->timeid = time();

				$channel->name = Input::get('name');
				$channel->description = Input::get('description');

				$channel->rtmp = Input::get('rtmp');
				$channel->rtmp_stream = Input::get('rtmp_stream');
				$channel->rtmp_user = Input::get('rtmp_user');
				$channel->rtmp_pass = Input::get('rtmp_pass');

				$pic_logo = Input::get('pic_logo');
				$pic_logo = !empty($pic_logo) ? $pic_logo : 'avatarTV';
				$channel->logo_uid = $pic_logo;

				$pic_cover = Input::get('pic_cover');
				$pic_cover = !empty($pic_cover) ? $pic_cover : 'cover';
				$channel->cover_uid = $pic_cover;

				$pic_back = Input::get('pic_back');
				$pic_back = !empty($pic_back) ? $pic_back : 'background';
				$channel->background_uid = $pic_back;

				$channel->save();
				return Redirect::to(route('appanel.channels.index'));
			}
		} else {
			return Redirect::to(route('appanel.channels.index'));
		}
	}

	public function edit ($uid) {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->channels->edit) {
			$channel = Channel::where('uid', '=', $uid)->take(1)->get();
			$data = array(
				'title' => 'Canales',
				'subtitle' => "Editar canal <strong>" . $channel[0]->title . "</strong>",
				'section' => 'channels',
				'channel' => $channel[0]
			);
			return View::make('appanel/channels/edit', $data);
		} else {
			return Redirect::to(route('appanel.channels.index'));
		}
	}

	// Store
	public function update () {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->channels->edit) {
			//validation videos
			$rules = array (
				'name' => 'required',
				'description' => 'required',
				'rtmp' => array('required',
					'regex:/^rtmp\:\/\/(|[a-z0-9]{3,}\.)[a-z0-9]{3,}\.[a-z]{2,5}(|\:[0-9]{1,5})\/(.+)$/')
			);

			$messages = array (
				'name.required' => 'El nombre es necesario',
				'description.required' => 'Es necesrio colocar descripción',
				'rtmp.required' => 'Es necesario colocar un canal RTMP',
				'rtmp.regex' => 'El RTMP no es válido'
			);

			//check validation
			$validator = Validator::make(Input::all(), $rules, $messages);

			if ($validator->fails()) {
				$messages = $validator->messages();
				return Redirect::route('appanel.channels.create')
					->withErrors($validator)
					->withInput();
			} else {
				$channels = Channel::where('uid', '=', $uid)->take(1)->get();
				$channel = $channels[0];

				$channel->uid =  uniqid();
				$channel->timeid = time();

				$channel->name = Input::get('name');
				$channel->description = Input::get('description');

				$channel->rtmp = Input::get('rtmp');
				$channel->rtmp_stream = Input::get('rtmp_stream');
				$channel->rtmp_user = Input::get('rtmp_user');
				$channel->rtmp_pass = Input::get('rtmp_pass');

				$pic_logo = Input::get('pic_logo');
				$pic_logo = !empty($pic_logo) ? $pic_logo : 'avatarTV';
				$channel->logo_uid = $pic_logo;

				$pic_cover = Input::get('pic_cover');
				$pic_cover = !empty($pic_cover) ? $pic_cover : 'cover';
				$channel->cover_uid = $pic_cover;

				$pic_back = Input::get('pic_back');
				$pic_back = !empty($pic_back) ? $pic_back : 'background';
				$channel->background_uid = $pic_back;

				$channel->save();
				return Redirect::to(route('appanel.channels.index'));
			}
		} else {
			return Redirect::to(route('appanel.channels.index'));
		}
	}
}








