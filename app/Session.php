<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model {
	public function user() {
		return $this->belongsTo('App\User');
	}

	public static function connectedUsers() {
		return self::whereNotNull('user_id')->get();
	}
}
