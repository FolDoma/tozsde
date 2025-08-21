<?php

namespace App\Livewire;

use App\Models\Games;
use Livewire\Component;

class Main extends Component
{
    public $classes, $games, $multipliers = [], $game, $class, $bet, $player_gets, $player_multiplier, $records, $bet_average, $sum_cashout, $sum_bet = 0, $cashout_average, $base_multiplier = 1.3;

    public function mount()
    {
        $this->get_data();
    }

    public function get_data()
    {
        $this->games = Games::all();
        foreach ($this->games as $game) {
            $this->multipliers[$game->id] = $game->manual_multiplier ?? '';
        }
    }

    public function render()
    {
        return view('livewire.main');
    }
}
