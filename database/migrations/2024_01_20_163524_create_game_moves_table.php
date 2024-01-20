<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the 'games' table
        if (!Schema::hasTable('games')) {
            Schema::create('games', function (Blueprint $table) {
                $table->id();
                $table->enum('winner', ['X', 'O', null])->nullable();
                $table->timestamps();
            });
        }

        // Create the 'game_moves' table
        if (!Schema::hasTable('game_moves')) {
            Schema::create('game_moves', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('game_id');
                $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
                $table->string('player', 1); // 'X' or 'O'
                $table->unsignedTinyInteger('row'); // 0, 1, 2
                $table->unsignedTinyInteger('col'); // 0, 1, 2
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_moves');
        Schema::dropIfExists('games');
    }
}
