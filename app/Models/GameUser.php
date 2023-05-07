<?php

namespace App\Models;

use App\Enums\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GameUser extends Pivot
{
	protected $table = 'game_user';

	protected $casts = [
		'color' => Color::class,
	];
}
