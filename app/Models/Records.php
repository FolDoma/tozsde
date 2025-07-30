<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Game;
use App\Models\ClassModel; // rename if your class model isn't called "Class"

class Records extends Model
{
    public function game()
    {
        return $this->belongsTo(Games::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
