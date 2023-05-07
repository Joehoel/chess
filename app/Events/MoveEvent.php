<?php

namespace App\Events;

use App\Broadcasting\GameChannel;
use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use PChess\Chess\Move;

class MoveEvent implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;


	/**
	 * Create a new event instance.
	 */
	public function __construct(public Game $game, public array $move)
	{

		//
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return array<int, \Illuminate\Broadcasting\Channel>
	 */
	public function broadcastOn(): array
	{
		return [
			new Channel('game.' . $this->game->id),
		];
	}

	public function broadcastWith(): array
	{
		return [
			'move' => $this->move,
			'game' => $this->game->only(['id']),
		];
	}
}
