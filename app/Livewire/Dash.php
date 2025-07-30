<?php

namespace App\Livewire;

use App\Models\Classes;
use App\Models\Games;
use App\Models\Records;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;


class Dash extends Component
{
    public $classes, $games, $multipliers = [], $game, $class, $bet, $player_gets, $player_multiplier, $records;

    public function mount()
    {
        $this->get_data();
    }

    public function get_data()
    {
        $this->classes = Classes::all();
        $this->games = Games::all();
        foreach ($this->games as $game) {
            $this->multipliers[$game->id] = $game->manual_multiplier ?? '';
        }
        $this->records = Records::orderBy('id', 'desc')->limit(20)->get();
        foreach ($this->records as $record) {
            $record->player_gets = $record->multiplier * $record->bet;
        }
    }

    public function updatedMultipliers($value, $key)
    {
        $game = Games::find($key);
        if ($game && $game->manual_multiplier !== null) {
            $game->manual_multiplier = $value ?: null;
            $game->save();
        } else {
            $game->manual_multiplier = $value ?: null;
            $game->save();
        }
    }

    public function toggleManual($gameId)
    {
        $game = Games::find($gameId);
        if ($game) {
            if ($game->manual_multiplier !== null) {
                $game->manual_multiplier = null;
            } else {
                $game->manual_multiplier = $this->multipliers[$gameId] ?: $game->multiplier;
            }
            $game->save();
        }

        $this->games = Games::all(); // Refresh
    }

    public function save()
    {
        // dd($this->game, $this->class, $this->bet);
        $multiplier = Games::find($this->game)->manual_multiplier ?? Games::find($this->game)->multiplier;
        DB::table('records')->insert([
            'game_id' => $this->game,
            'class_id' => $this->class,
            'multiplier' => $multiplier,
            'bet' => $this->bet,
        ]);
        $this->player_gets = $multiplier * $this->bet;
        $this->player_multiplier = $multiplier;
        $this->reset(['game', 'class', 'bet']);
        $this->get_data();
    }

    public function fetch_sheets()
    {
        $response = Http::get('https://docs.google.com/spreadsheets/d/1Br891asFKvPf4BsdsvnIesKA8MG060i1/gviz/tq?tqx=out:json');
        $raw = $response->body(); // Get raw text

        // Remove the JS function wrapper
        $jsonStart = strpos($raw, '{');
        $wrappedJson = substr($raw, $jsonStart, -2); // Remove trailing ");"
        $data = json_decode($wrappedJson, true);

        // Get the rows as a clean array
        $columns = array_map(fn($col) => $col['label'], $data['table']['cols']);

        $rows = collect($data['table']['rows'])->map(function ($row) use ($columns) {
            $values = array_map(fn($cell) => $cell['v'] ?? null, $row['c']);
            return array_combine($columns, $values);
        });

        // dd($rows);

        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');  // Disable foreign key checks
        // Classes::truncate();
        Games::truncate();
        Records::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');  // Re-enable foreign key checks

        foreach ($rows as $row) {
            // dd($row);
            if ($row['Játék'] != '' && $row['Játék'] != "Hárem" && $row['Játék'] != "Bank") {
                DB::table('games')->insert([
                    'name' => $row['Játék'],
                    'room' => $row['Helyszín'],
                ]);
            }
        }
        $this->reset();
        $this->get_data();
    }

    public function render()
    {
        return view('livewire.dash');
    }
}
