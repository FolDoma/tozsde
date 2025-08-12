<div wire:poll="get_data" class="w-full h-full">
    <div class="w-full flex items-center">
        <p class="text-lg">Tozsde 2025</p>
        <button class="ml-auto"><span class="material-symbols-outlined">tune</span></button>
    </div>
    <div>
        <button type="button" wire:click="fetch_sheets" class="bg-accent border-success border p-2 rounded-md mb-2">Fetch sheets</button>
    </div>


    <div class="gap-4 grid grid-cols-1 lg:grid-cols-5">
        <div class="p-2 border border-border rounded-md w-full bg-content-1 lg:col-span-3 2xl:col-span-2">
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="p-2">Game</th>
                        <th class="pl-4 p-2">Room</th>
                        <th class="pl-8 p-2">Multi X</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dashed divide-text/40">
                    @foreach($games as $game)
                    <tr wire:key="{{$game->id}}">
                        <td class="p-2">{{$game->name}}</td>
                        <td class="pl-4 p-2">{{$game->room}}</td>
                        <td class="pl-8 p-2 flex">
                            <div class="ml-auto">{{$game->manual_multiplier ?? $game->multiplier}} X</div>
                            <div class="ml-4 flex">
                                <!-- <p class="mr-2">Auto</p> -->
                                <label for="toggle-{{$game->id}}" class="relative block h-6 w-10 rounded-full bg-content-3 transition-colors [-webkit-tap-highlight-color:_transparent] has-checked:bg-error">
                                    <input wire:click="toggleManual({{ $game->id }})" type="checkbox" id="toggle-{{$game->id}}" class="peer sr-only" @if($game->manual_multiplier) checked @endif @if(!$game->manual_multiplier) disabled @endif />
                                    <span
                                        class="absolute inset-y-0 start-0 m-1 size-4 rounded-full bg-content-2 ring-[4px] ring-text transition-all ring-inset peer-checked:start-6 peer-checked:w-1.5 peer-checked:bg-white peer-checked:ring-transparent">
                                    </span>
                                </label>
                                <!-- <p class="ml-2">Manual</p> -->
                                <input wire:model.lazy="multipliers.{{ $game->id }}" type="number" class="ml-2 h-6 w-12 rounded-md border border-border bg-content-2 text-center [-moz-appearance:_textfield] [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none @if($game->manual_multiplier) border-error @endif " />
                                <p class="ml-2">X</p>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <form wire:submit="save" class="p-2 border border-border rounded-md w-full bg-content-1 lg:col-span-2 2xl:col-span-2">
            <p>Add ticket</p>
            <p>Choose class:</p>
            <div class="grid grid-cols-2">
                <div class="">
                    @foreach($games as $game)
                    <div class="p-1">
                        <label for="game-{{$game->id}}" class="flex items-center rounded-lg border border-border bg-content-2 p-1 shadow-sm transition-colors hover:bg-content-3 has-checked:border-success has-checked:ring-1 has-checked:ring-success">
                            <p class="self-center">{{$game->name}}</p>
                            <input wire:model="game" required type="radio" name="game-selector" value="{{$game->id}}" id="game-{{$game->id}}" class="sr-only" />
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="p-2">
                    <div class="border border-border grid grid-cols-5 rounded-md divide-x divide-border overflow-hidden">
                        @foreach($classes as $class)
                        <label for="class-{{$class->id}}" class="flex justify-center bg-content-2 p-1 transition-colors hover:bg-content-3  has-checked:bg-success has-checked:text-content-1">
                            <p class="self-center">{{$class->name}}</p>
                            <input wire:model="class" required type="radio" name="class-selector" value="{{$class->id}}" id="class-{{$class->id}}" class="sr-only"/>
                        </label>
                        @endforeach
                    </div>
                    <div class="">
                        <div class="flex p-2">
                            <p class="">Bet</p>
                            <input wire:model="bet" required type="number" name="bet" class="ml-2 h-6 w-full rounded-md border border-border bg-content-2 text-center [-moz-appearance:_textfield] [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none" />
                            <button type="submit" class="self-center h-6 ml-2 border border-success rounded-lg bg-success/10 hover:bg-success hover:text-content-1 focus:bg-content-1 focus:text-text-lighter"><span class="material-symbols-outlined">upload</span></button>
                        </div>
                        <p class="">Multiplier --> {{$player_multiplier}}</p>
                        <p class="">Player gets --> {{$player_gets}}</p>
                    </div>
                </div>
            </div>
        </form>
        <div class="p-2 border border-border rounded-md w-full bg-content-1 divide-y divide-dashed divide-text/40">
            @foreach($records as $record)
            <div class="">
                {{$record->game->name}}
                {{$record->class->name}}
                {{$record->player_gets}}
            </div>
            @endforeach
        </div>
        <div class="p-2 mb-10 border border-border rounded-md w-full bg-content-1 lg:col-span-2">
            <div>Bet average: {{$bet_average}}</div>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Cashout</th>
                        <th>Multi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                    <tr>
                        <td class="text-center">{{$record->game->name}}</td>
                        <td class="text-center">{{$record->game->cashout}}</td>
                        <td class="text-center">{{$record->game->multiplier}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>