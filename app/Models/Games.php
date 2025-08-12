<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    protected $appends = ['cashout'];

    public function getCashoutAttribute()
    {
        return Records::where('game_id', $this->id)->sum('bet');
    }
}
