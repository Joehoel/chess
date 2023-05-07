<?php

namespace App\Http\Controllers;

use App\Enums\Color;
use App\Events\MoveEvent;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\CreateGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use PChess\Chess\Move;

class GameController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		return Inertia::render("Game/Index", [
			'games' => Game::all(),
		]);
	}

	public function move($id, Request $request)
	{
		$game = Game::findOrFail($id);

		event(new MoveEvent($game, $request->all()));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreGameRequest $request): RedirectResponse
	{
		// dd($request);

		$game = Game::create($request->only("name"));

		$game->save();

		return to_route('game.index', ['game' => $game]);
	}

	public function join(string $id)
	{
		$game = Game::findOrFail($id);

		// Check if the user is not already in the game
		$user = Auth::user();

		if (!$user->games()->find($game->id)) {
			$color = $game->player_count % 2 === 0 ? Color::WHITE : Color::BLACK;

			// Attach the user to the game
			$user->games()->attach($game, ['color' => $color]);
			// Increase the player count
			$game->increment('player_count');
		}

		$color = $user->games()->find($game->id)->pivot->color;

		return to_route('game.show', ['id' => $game->id]);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		$game = Game::findOrFail($id);
		$user = Auth::user();

		$color = $user->games()->find($game->id)->pivot->color;

		return Inertia::render("Game/Show", [
			'game' => $game,
			'color' => $color,
		]);
	}
}
