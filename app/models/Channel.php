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
		$events = $this->hasMany('Evento', 'channel_uid', 'uid')->where('started_at', '<', Carbon::now())->orderBy('ended_at', 'desc')->take(1);
		$results = $events->count();

		if ($results) {
			$event = $events->get()[0];
			$ended = strtotime($event->ended_at);
			$start = strtotime($event->started_at);
			$now = time();

			if ($ended > $now && $now > $start) {
				return $event;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
