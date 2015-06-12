<?php

class IndexController extends BaseController {
	public function index () {

		$last_events = Evento::orderBy('ended_at', 'desc')->take(3)->get();

		$channels = Channel::orderBy('id', 'desc')->get();

		$data = array (
			'title' => "Inicio",
			'last_events' => $last_events,
			'channels' => $channels
		);
		return View::make('home/index', $data);
	}

	public function channel ($uid, $void) {
	}

	public function event ($uid, $void) {
		$events = Evento::where('uid', '=', $uid)->take(1);
		$results = $events->count();

		$event = $events->get()[0];
		if ($results > 0) {
			$data = array (
				'title' => $event->title,
				'event' => $event
			);
			return View::make('home/event', $data);
		} else {
			echo "404 - No se encontró el evento";
		}
	}

	public function search ($search) {

	}

	public function events () {
		$channels = Channel::orderBy('id', 'desc')->get();

		$data = array (
			'title' => "Inicio",
			'channels' => $channels
		);
		return View::make('home/events', $data);
	}
}