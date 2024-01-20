<?php
// Game.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['winner'];

    public function moves()
    {
        return $this->hasMany(GameMove::class);
    }
}
