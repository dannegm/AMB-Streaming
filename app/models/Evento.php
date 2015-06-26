<?php

class Evento extends Eloquent {
	protected $table = 'eventos';
	public function channel () {
		return $this->hasOne('Channel', 'uid', 'channel_uid');
	}

	public function logo () {
		return $this->hasOne('Picture', 'uid', 'logo_uid');
	}
	public function cover () {
		return $this->hasOne('Picture', 'uid', 'cover_uid');
	}
	public function background () {
		return $this->hasOne('Picture', 'uid', 'background_uid');
	}

	public function start_date_human () {
		$dt = Carbon::parse( $this->started_at );
		return $dt->toFormattedDateString();
	}

	public function ended_date_human () {
		$dt = Carbon::parse( $this->ended_at );
		return $dt->toFormattedDateString();
	}

	public function isLive () {
		$ended = strtotime($this->ended_at);
		$start = strtotime($this->started_at);
		$now = time();

		if ($ended > $now && $now > $start) {
			return true;
		} else {
			return false;
		}
	}

	public function isFinish () {
		$ended = strtotime($this->ended_at);
		$now = time();

		if ($ended < $now) {
			return true;
		} else {
			return false;
		}
	}
}
