<?php

class EventsController extends \BaseController {

	/**
	Views
	*/
	public function index () {
		$events = Evento::orderBy('id', 'desc')->get();
		$data = array (
			'title' => 'Eventos',
			'subtitle' => "Todos los eventos",
			'events' => $events
		);
		return View::make('appanel/events/index', $data);
	}
	public function create () {
		$channels = Channel::orderBy('id', 'desc')->get();
		$data = array(
			'title' => 'Eventos',
			'subtitle' => "Nuevo evento",
			'channels' => $channels
		);
		return View::make('appanel/events/create', $data);
	}

	// Store
	public function store() {
		//validation videos
		$rules = array(
			'name' => 'required',
			'description' => 'required',
			'channel' => 'required'
		);

		$messages = array(
			'name.required' => 'El nombre es necesario',
			'description.required' => 'Es necesrio colocar descripción',
			'channel.required' => 'Es necesrio asignarle un canal'
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

			$event->title = Input::get('name');
			$event->subtitle = Input::get('description');

			$event->started_at = Input::get('started_at');
			$event->ended_at = Input::get('ended_at');

			$event->save();
			return Redirect::to(route('appanel.events.index'));
		}
	}
}








