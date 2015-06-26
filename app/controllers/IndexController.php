<?php

class IndexController extends BaseController {
	public function index () {

		$marks_events = Evento::where('marked', '=', 1)->orderBy('ended_at', 'desc')->take(3)->get();
		$last_events = Evento::orderBy('ended_at', 'desc')->take(3)->get();

		$channels = Channel::where('visible', '=', 1)->orderBy('id', 'desc')->take(3)->get();

		$data = array (
			'title' => "Inicio",
			'marks_events' => $marks_events,
			'last_events' => $last_events,
			'channels' => $channels
		);
		return View::make('home/index', $data);
	}

	public function channel ($uid, $void) {
		$channels = Channel::where('uid', '=', $uid)->take(1);
		$channel = $channels->get()[0];

		$data = array (
			'title' => $channel->name,
			'channel' => $channel
		);
		return View::make('home/channel', $data);
	}

	public function event ($uid, $void) {
		$events = Evento::where('uid', '=', $uid)->take(1);
		$results = $events->count();

		if ($results > 0) {
			$event = $events->get()[0];
			$data = array (
				'title' => $event->title,
				'event' => $event
			);
			return View::make('home/event', $data);
		} else {
			return View::make('home/e404', $data);
		}
	}

	public function events () {
		$channels = Channel::where('visible', '=', 1)->orderBy('id', 'desc')->get();

		$data = array (
			'title' => "Inicio",
			'channels' => $channels
		);
		return View::make('home/events', $data);
	}

	public function e404 () {
		$data = array (
			'title' => '404: Página no encontrada'
		);
		return View::make('home/e404', $data);
	}

	public function search ($search) {

	}
}






