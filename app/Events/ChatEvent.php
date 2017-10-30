<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatEvent implements ShouldBroadcast {
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $data;

    /**
     * ChatEvent constructor.
     */
	public function __construct() {
		$this->data = array(
			'power' => '10',
		);
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
	 */
	public function broadcastOn() {
		return ['chat.message'];
	}
}
