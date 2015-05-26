<?php

class Evento extends Eloquent {
	protected $table = 'eventos';
	public function channel () {
		return $this->hasOne('Channel', 'uid', 'channel_uid');
	}
}
