<?php

class Channel extends Eloquent {
	protected $table = 'canales';

	public function logo () {
		return $this->hasOne('Picture', 'uid', 'logo_uid');
	}
	public function cover () {
		return $this->hasOne('Picture', 'uid', 'cover_uid');
	}
	public function background () {
		return $this->hasOne('Picture', 'uid', 'background_uid');
	}

	public function events () {
		return $this->hasMany('Evento', 'channel_uid', 'uid')->orderBy('ended_at', 'desc');
	}

	public function last_events ($n = 3) {
		return $this->hasMany('Evento', 'channel_uid', 'uid')->orderBy('ended_at', 'desc')->take($n)->get();
	}

	public function has_live () {
		$events = $this->events()->take(1)->get();
		$event = $events[0];

		date_default_timezone_set('america/mexico_city');
		$ended = strtotime($event->ended_at);
		$start = strtotime($event->started_at);
		$now = time();

		if ($ended > $now && $now > $start) {
			return $event;
		} else {
			return false;
		}
	}
}
