<?php

class PlayerController extends BaseController {
	// Make Player
	public function channel ($uid) {
		$channels = Channel::where('uid', '=', $uid)->take(1);
		$results = $channels->count();

		if ($results > 0) {
			$channel = $channels->get();
			$rtmp = $channel[0]->rtmp;
			if (!empty($rtmp)) {

				if ($channel[0]->online != 1) {
					$events = $channel[0]->events;
					if ($events->count() > 0) {

						$last_event = $events[0];

						$ended = strtotime($last_event->ended_at);
						$start = strtotime($last_event->started_at);
						$now = time();

						if ($ended > $now && $now > $start) {
							$data = array (
								'title' => $channel[0]->name,
								'rtmp' => $channel[0]->rtmp,
								'cover' => $channel[0]->cover->url,
								'autoplay' => ' autoplay',
								'type' => 'channel',
								'status' => 'live',
								'start' => $last_event->started_at
							);

							if ($last_event->psswdreq != 0) {
								$login = Cookie::get('L' . $last_event->uid);
								if ($login != $last_event->password) {
									$data['event'] = $event[0];
									return View::make('player/password', $data);
								} else {
									return View::make('player/index', $data);
								}
							} else {
								return View::make('player/index', $data);
							}

						} else {
							$data = array (
								'title' => $channel[0]->name,
								'cover' => '',
								'error' => 'Estamos fuera del aire'
							);
							return View::make('player/error', $data);
						}
					} else {
						$data = array (
							'title' => $channel[0]->name,
							'cover' => '',
							'error' => 'El canal no tiene ningún evento programado'
						);
						return View::make('player/error', $data);
					}
				} else {
					$data = array (
						'title' => $channel[0]->name,
						'rtmp' => $channel[0]->rtmp,
						'cover' => $channel[0]->cover->url,
						'autoplay' => ' autoplay',
						'type' => 'channel',
						'status' => 'live',
						'start' => Carbon::now()
					);

					return View::make('player/index', $data);
				}
			} else {
				$data = array (
					'title' => $channel[0]->name,
					'cover' => '',
					'error' => 'No hay una transmisión disponible'
				);
				return View::make('player/error', $data);
			}
		} else {
			$data = array (
				'title' => 'Error',
				'cover' => '',
				'error' => 'No pudimos encontrar este canal'
			);
			return View::make('player/error', $data);
		}
	}

	public function event ($uid) {
		$events = Evento::where('uid', '=', $uid)->take(1);
		$results = $events->count();

		if ($results > 0) {
			$event = $events->get();
			$rtmp = $event[0]->rtmp;
			$status = 'repeat';
			$autoplay = '';

			$start = strtotime($event[0]->started_at);
			$ended = strtotime($event[0]->ended_at);
			$now = time();

			$isDebug = null !== Input::get('debug') ? true : false;

			if ($start < $now || $isDebug) {
				if ($ended > $now) {
					$rtmp = $event[0]->channel->rtmp;
					$status = 'live';
					$autoplay = ' autoplay';
				}

				if (!empty($rtmp)) {
					$data = array (
						'title' => $event[0]->title,
						'rtmp' => $rtmp,
						'cover' => $event[0]->cover->url,
						'autoplay' => $autoplay,
						'type' => 'event',
						'status' => $status,
						'start' => $event[0]->started_at
					);

					if ($event[0]->psswdreq != 0) {
						$login = Cookie::get('L' . $event[0]->uid);
						if ($login != $event[0]->password) {
							$data['event'] = $event[0];
							return View::make('player/password', $data);
						} else {
							return View::make('player/index', $data);
						}
					} else {
						return View::make('player/index', $data);
					}
				} else {
					$data = array (
						'title' => $event[0]->title,
						'cover' => $event[0]->cover->url,
						'error' => 'Este evento no está listo para retransmitir'
					);
					return View::make('player/error', $data);
				}
			} else {
				$data = array (
					'title' => $event[0]->title,
					'date' => $event[0]->started_at,
					'cover' => $event[0]->cover->url
				);
				return View::make('player/soon', $data);
			}
		} else {
			$data = array (
				'title' => 'Error',
				'cover' => '',
				'error' => 'No pudimos encontrar este evento'
			);
			return View::make('player/error', $data);
		}
	}

	public function widget () {
		return Response::view('player/widget_api_js')->header('Content-Type', 'text/javascript');
	}

	public function unlock ($uid) {
		$events = Evento::where('uid', '=', $uid)->take(1);
		$results = $events->count();

		if ($results > 0) {
			$_event = $events->get();
			$event = $_event[0];

			$passc = Input::get('password');
			$passb = $event->password;

			if ($passc == $passb) {
				$dt = Carbon::parse( $event->ended_at );
				$minsLeft = $dt->diffInMinutes( Carbon::now() );

				Cookie::queue('L' . $uid, $passb, $minsLeft);
				return Redirect::to(route('player.event', array('uid' => $uid)));
			}
				return Redirect::to(route('player.event', array('uid' => $uid)))
					->withErrors(array('La contraseña es incorrecta'));
		} else {
			$data = array (
				'title' => 'Error',
				'cover' => '',
				'error' => 'No pudimos encontrar este evento'
			);
			return View::make('player/error', $data);
		}
	}
}










