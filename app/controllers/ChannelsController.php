<?php

class ChannelsController extends \BaseController {

	/**
	Views
	*/
	public function index () {
		$channels = Channel::orderBy('id', 'desc')->get();
		$data = array (
			'title' => 'Canales',
			'subtitle' => "Todos los canales",
			'channels' => $channels
		);
		return View::make('appanel/channels/index', $data);
	}
	public function create () {
		$data = array(
			'title' => 'Canales',
			'subtitle' => "Nuevo canal"
		);
		return View::make('appanel/channels/create', $data);
	}

	// Store
	public function store() {
		//validation videos
		$rules = array(
			'name' => 'required',
			'description' => 'required',
			'rtmp' => array('required',
				'regex:/^rtmp\:\/\/[a-z0-9]{3,}\.[a-z]{2,5}(|\:[0-9]{1,5})\/(.+)$/')
		);

		$messages = array(
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

			$channel->save();
			return Redirect::to(route('appanel.channels.index'));
		}
	}
}








