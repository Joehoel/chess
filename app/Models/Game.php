<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read User $users
 */
class Game extends Model
{
	use HasFactory, HasUuids;

	// Fillable
	protected $fillable = [
		'id', 'name'
	];

	public function users(): BelongsToMany
	{
		return $this->belongsToMany(Game::class);
	}
}
