<?php

namespace App\Livewire;

use App\Models\Games;
use App\Models\Settings;
use Carbon\Carbon;
use Livewire\Component;

class Main extends Component
{
    public $classes, $games, $multipliers = [], $game, $class, $bet, $player_gets, $player_multiplier, $records, $bet_average, $sum_cashout, $sum_bet = 0, $cashout_average, $base_multiplier = 1.3, $calculate_time, $calculate_time_temp;

    public function mount()
    {
        $timeValue = Settings::where('name', 'calculate_time')->value('value');
        $this->calculate_time_temp = $timeValue ? Carbon::parse($timeValue)->toIso8601String() : null;
        $this->get_data();
    }

    public function get_data()
    {
        $this->games = Games::all();
        foreach ($this->games as $game) {
            $this->multipliers[$game->id] = $game->manual_multiplier ?? '';
        }
        $timeValue = Settings::where('name', 'calculate_time')->value('value');
        $this->calculate_time = $timeValue ? Carbon::parse($timeValue)->toIso8601String() : null;
        if ($this->calculate_time != $this->calculate_time_temp) {
            $this->dispatch('reload-page');
        }
    }

    public function render()
    {
        return view('livewire.main');
    }
}
