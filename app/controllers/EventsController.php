<?php

class EventsController extends \BaseController {

	/**
	Views
	*/
	public function index () {
		$events = Evento::orderBy('ended_at', 'desc')->get();
		$data = array (
			'title' => 'Eventos',
			'subtitle' => 'Todos los eventos',
			'section' => 'events',
			'events' => $events
		);
		return View::make('appanel/events/index', $data);
	}
	public function create () {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->events->create) {
			$channels = Channel::orderBy('id', 'desc')->get();
			$data = array(
				'title' => 'Eventos',
				'subtitle' => "Nuevo evento",
				'section' => 'events',
				'channels' => $channels
			);
			return View::make('appanel/events/create', $data);
		} else {
			return Redirect::to(route('appanel.events.index'));
		}
	}

	public function delete ($uid) {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->events->delete) {
			$evento = Evento::where('uid', '=', $uid)->take(1)->get();
			$evento[0]->delete();
		}
		return Redirect::to(route('appanel.events.index'));
	}

	public function view ($uid) {
		$evento = Evento::where('uid', '=', $uid)->take(1)->get();
		$data = array(
			'title' => 'Eventos',
			'subtitle' => "Información",
			'section' => 'events',
			'event' => $evento[0]
		);
		return View::make('appanel/events/view', $data);
	}

	// Store
	public function store () {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->events->create) {
			//validation videos
			$rules = array(
				'title' => 'required',
				'description' => 'required',
				'channel' => 'required',
				'started_at' => 'required',
				'ended_at' => 'required'
			);

			$messages = array(
				'title.required' => 'El nombre es necesario',
				'description.required' => 'Es necesrio colocar descripción',
				'channel.required' => 'Es necesrio asignarle un canal',
				'started_at.required' => 'Debes seleccionar fecha de inicio',
				'ended_at.required' => 'Debes seleccionar fecha de cierre'
			);

			//check validation
			$validator = Validator::make(Input::all(), $rules, $messages);

			if ($validator->fails()) {
				$messages = $validator->messages();
				return Redirect::route('appanel.events.create')
					->withErrors($validator)
					->withInput();
			} else {
				$event = new Evento;

				$event->uid =  uniqid();
				$event->timeid = time();

				$event->channel_uid = Input::get('channel');

				$event->title = Input::get('title');
				$event->subtitle = Input::get('subtitle');
				$event->description = Input::get('description');

				$event->locale = Input::get('locale');

				$event->started_at = Input::get('started_at');
				$event->ended_at = Input::get('ended_at');

				$event->theme = Input::get('theme');

				$pic_logo = Input::get('pic_logo');
				$pic_logo = !empty($pic_logo) ? $pic_logo : 'avatarTV';
				$event->logo_uid = $pic_logo;

				$pic_cover = Input::get('pic_cover');
				$pic_cover = !empty($pic_cover) ? $pic_cover : 'cover';
				$event->cover_uid = $pic_cover;

				$pic_back = Input::get('pic_back');
				$pic_back = !empty($pic_back) ? $pic_back : 'background';
				$event->background_uid = $pic_back;

				$event->save();
				return Redirect::to(route('appanel.events.view', array('uid' => $event->uid)));
			}
		} else {
			return Redirect::to(route('appanel.events.index'));
		}
	}

	public function edit ($uid) {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->events->edit) {
			$channels = Channel::orderBy('id', 'desc')->get();
			$evento = Evento::where('uid', '=', $uid)->take(1)->get();
			$data = array(
				'title' => 'Eventos',
				'subtitle' => "Editar evento <strong>" . $evento[0]->title . "</strong>",
				'section' => 'events',
				'channels' => $channels,
				'event' => $evento[0]
			);
			return View::make('appanel/events/edit', $data);
		} else {
			return Redirect::to(route('appanel.events.index'));
		}
	}

	public function update ($uid) {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->events->edit) {
			//validation videos
			$rules = array(
				'title' => 'required',
				'description' => 'required',
				'channel' => 'required',
				'started_at' => 'required',
				'ended_at' => 'required'
			);

			$messages = array(
				'title.required' => 'El nombre es necesario',
				'description.required' => 'Es necesrio colocar descripción',
				'channel.required' => 'Es necesrio asignarle un canal',
				'started_at.required' => 'Debes seleccionar fecha de inicio',
				'ended_at.required' => 'Debes seleccionar fecha de cierre'
			);

			//check validation
			$validator = Validator::make(Input::all(), $rules, $messages);

			if ($validator->fails()) {
				$messages = $validator->messages();
				return Redirect::route('appanel.events.create')
					->withErrors($validator)
					->withInput();
			} else {
				$evento = Evento::where('uid', '=', $uid)->take(1)->get();
				$event = $evento[0];

				$event->channel_uid = Input::get('channel');

				$event->title = Input::get('title');
				$event->subtitle = Input::get('subtitle');
				$event->description = Input::get('description');

				$event->locale = Input::get('locale');
				$event->rtmp = Input::get('rtmp');

				$event->ftp_host = Input::get('ftp_host');
				$event->ftp_port = Input::get('ftp_port');
				$event->ftp_user = Input::get('ftp_user');
				$event->ftp_pass = Input::get('ftp_pass');

				$event->started_at = Input::get('started_at');
				$event->ended_at = Input::get('ended_at');

				$event->theme = Input::get('theme');
				$event->nrecord = Input::get('nrecord');

				$pic_logo = Input::get('pic_logo');
				$pic_logo = !empty($pic_logo) ? $pic_logo : 'avatarTV';
				$event->logo_uid = $pic_logo;

				$pic_cover = Input::get('pic_cover');
				$pic_cover = !empty($pic_cover) ? $pic_cover : 'cover';
				$event->cover_uid = $pic_cover;

				$pic_back = Input::get('pic_back');
				$pic_back = !empty($pic_back) ? $pic_back : 'background';
				$event->background_uid = $pic_back;

				$event->save();
				return Redirect::to(route('appanel.events.view', array('uid' => $uid)));
			}
		} else {
			return Redirect::to(route('appanel.events.index'));
		}
	}

	public function addHour ($uid) {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->events->edit) {
			$evento = Evento::where('uid', '=', $uid)->take(1)->get();
			$event = $evento[0];

			$dt = Carbon::parse( $event->ended_at );
			$dt->addHour();

			$event->ended_at = $dt;
			$event->save();

			return Redirect::to(route('appanel.events.view', array('uid' => $uid)));
		} else {
			return Redirect::to(route('appanel.events.view', array('uid' => $uid)));
		}
	}

	public function finish ($uid) {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->events->edit) {
			$evento = Evento::where('uid', '=', $uid)->take(1)->get();
			$event = $evento[0];

			$event->ended_at = Carbon::now();
			$event->save();

			return Redirect::to(route('appanel.events.view', array('uid' => $uid)));
		} else {
			return Redirect::to(route('appanel.events.view', array('uid' => $uid)));
		}
	}

	public function mark ($uid) {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->events->edit) {
			$evento = Evento::where('uid', '=', $uid)->take(1)->get();
			$event = $evento[0];

			$event->marked = 1;
			$event->save();

			return Redirect::to(route('appanel.events.index'));
		} else {
			return Redirect::to(route('appanel.events.index'));
		}
	}

	public function unmark ($uid) {
		$selfuser = Auth::user();
		$permissions = $selfuser->permissions();
		if ($permissions->events->edit) {
			$evento = Evento::where('uid', '=', $uid)->take(1)->get();
			$event = $evento[0];

			$event->marked = 0;
			$event->save();

			return Redirect::to(route('appanel.events.index'));
		} else {
			return Redirect::to(route('appanel.events.index'));
		}
	}
}








