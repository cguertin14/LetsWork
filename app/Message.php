<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {
	protected $fillable = [
		'sender_id', 'receiver_id', 'content',
	];

	public function files() {
		return $this->belongsToMany('App\File')->using('App\MessageFile')->withTimestamps();
	}

	public function sender() {
		return $this->belongsTo('App\User', 'sender_id');
	}

	public function receiver() {
		return $this->belongsTo('App\User', 'receiver_id');
	}
}