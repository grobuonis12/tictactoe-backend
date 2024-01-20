<?php

// GameMove.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameMove extends Model
{
    protected $fillable = ['game_id', 'player', 'row', 'col'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
