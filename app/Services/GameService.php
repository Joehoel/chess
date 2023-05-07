<?php

namespace App\Services;

use App\Models\Game;
use App\Models\User;

class GameService
{

	public function __construct(protected Game $game)
	{
	}

	public function getInfo()
	{
		return [
			'moves' => $this->game->only(['id', 'token', 'start_at', 'end_at', 'winner_color']),
		];
	}

	public static function notInGame(User $user, string $token): bool
	{
		return !$user->games()->where('token', $token)->exists();
	}
}
