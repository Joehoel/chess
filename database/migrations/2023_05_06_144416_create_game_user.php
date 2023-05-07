<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('game_user', function (Blueprint $table) {
			$table->id();
			$table->foreignUuid('game_id');
			$table->unsignedBigInteger('user_id')->unique();

			$table->enum('color', ['black', 'white'])->nullable();

			$table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('game_user');
	}
};
