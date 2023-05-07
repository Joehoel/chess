<?php

namespace App\Broadcasting;

use App\Models\Game;
use App\Models\User;

class GameChannel
{
	/**
	 * Authenticate the user's access to the channel.
	 */
	public function join(User $user, string $token): array|bool
	{
		$game = Game::getByToken($token);

		$exists = $game->users()->find($user->id);

		if (!$exists) {
			return false;
		}

		$color = $user->games()->firstWhere("token", $token)->pivot->color;

		return [
			'id' => $user->id,
			'name' => $user->name,
			'color' => $color,
		];
	}
}
