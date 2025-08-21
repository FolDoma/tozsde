<div wire:poll="get_data" class="w-full h-full">
    <div class="w-full flex items-center">
        <p class="text-lg">Tozsde 2025</p>
        <div class="relative inline-flex ml-auto mb-2 z-40" x-data="{ open: false }" @click.outside="open = false">
            <span class="inline-flex divide-x divide-border overflow-hidden rounded-md border border-border bg-content-1 shadow-sm">
                <button type="button" class="px-3 py-1.5 text-sm font-medium transition-colors hover:bg-content-2 hover:text-text focus:bg-content-2 focus:text-text text-text-light focus:relative">Main page -></button>
                <button type="button" @click="open = !open" class="px-3 py-1.5 text-sm font-medium transition-colors hover:bg-content-2 hover:text-text focus:bg-content-2 focus:text-text text-text-light focus:relative" aria-label="Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </span>
            <div role="menu" x-show="open" x-transition class="absolute end-0 top-12 z-auto w-56 divide-y divide-border overflow-hidden rounded border border-border bg-content-1 shadow-sm" style="display: none;">
                <div>
                    <p class="block px-3 py-2 text-sm text-text-lighter">General</p>
                    <a href="#" class="block px-3 py-2 text-sm font-medium transition-colors hover:bg-content-2 hover:text-text focus:bg-content-2 focus:text-text text-text-light" role="menuitem">Storefront</a>
                    <a href="#" class="block px-3 py-2 text-sm font-medium transition-colors hover:bg-content-2 hover:text-text focus:bg-content-2 focus:text-text text-text-light" role="menuitem">Warehouse</a>
                    <a href="#" class="block px-3 py-2 text-sm font-medium transition-colors hover:bg-content-2 hover:text-text focus:bg-content-2 focus:text-text text-text-light" role="menuitem">Stock</a>
                    <div class="px-3 py-2 text-text-light border-t border-border">
                        <div class="text-center px-3 py-2">Base multiplier</div>
                        <div class="flex justify-between w-full">
                            <div>Less</div>
                            <div>{{$base_multiplier}}</div>
                            <div>More</div>
                        </div>
                        <input wire:model.live="base_multiplier" type="range" step="0.1" min="1" max="1.6" class="h-2 w-full cursor-ew-resize appearance-none rounded-full bg-content-3 text-green-600 disabled:cursor-not-allowed accent-secondary [::-webkit-slider-thumb]:bg-seaccent-secondary [::-moz-range-thumb]:bg-seaccent-secondary">
                    </div>
                </div>
                <div>
                    <p class="block px-3 py-2 text-sm text-text-lighter">Maintain</p>
                    <div class="flex items-center px-3 py-2">
                        <span class="mr-2">Debug view</span>
                        <div class="flex items-center cursor-pointer relative ml-auto">
                            <input type="hidden" name="admin" value="0">
                            <input type="checkbox" name="admin" value="1" class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-border checked:bg-secondary checked:border-slate-800" id="check" />
                            <span class="absolute text-text opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <button type="button" wire:click="fetch_sheets" class="block w-full px-3 py-2 text-left text-sm font-medium text-error transition-colors hover:bg-error/10 focus:bg-error/10">Fetch sheets/delete db</button>
                </div>
            </div>
        </div>
    </div>

    <div class="gap-4 grid grid-cols-1 lg:grid-cols-2 grid-flow-row">
        <div class="border border-border rounded-md w-full bg-content-1 overflow-auto">
            <table class="table-auto w-full">
                <thead class="p-2 border-b border-text/40 bg-content-2">
                    <tr class="">
                        <th class="p-2 text-left">Game</th>
                        <th class="p-2 text-left">Room</th>
                        <th class="p-2 text-left">Cashout</th>
                        <th class="p-2 text-right">Multi X</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-solid divide-text/40 p-2">
                    @foreach($games as $game)
                    <tr wire:key="{{$game->id}}">
                        <td class="p-2">{{$game->name}}</td>
                        <td class="p-2">{{$game->room}}</td>
                        <td class="p-2">{{$game->cashout}}</td>
                        <td class="p-2 flex">
                            <div class="ml-auto">{{$game->manual_multiplier ?? $game->multiplier}}</div>
                            <div class="ml-2 flex">
                                <label for="toggle-{{$game->id}}" class="relative block h-6 w-10 rounded-full bg-content-3 transition-colors [-webkit-tap-highlight-color:_transparent] has-checked:bg-error">
                                    <input wire:click="toggleManual({{ $game->id }})" type="checkbox" id="toggle-{{$game->id}}" class="peer sr-only" @if($game->manual_multiplier) checked @endif @if(!$game->manual_multiplier) disabled @endif />
                                    <span
                                        class="absolute inset-y-0 start-0 m-1 size-4 rounded-full bg-content-2 ring-[4px] ring-text transition-all ring-inset peer-checked:start-6 peer-checked:w-1.5 peer-checked:bg-white peer-checked:ring-transparent">
                                    </span>
                                </label>
                                <input wire:model.lazy="multipliers.{{ $game->id }}" type="number" class="ml-2 h-6 w-12 rounded-md border border-border bg-content-2 text-center [-moz-appearance:_textfield] [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none @if($game->manual_multiplier) border-error @endif " />
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-2 border border-border rounded-md w-full bg-content-1">
            <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-2 ">
                <div class="flex flex-wrap">
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
                            <input wire:model="class" required type="radio" name="class-selector" value="{{$class->id}}" id="class-{{$class->id}}" class="sr-only" />
                        </label>
                        @endforeach
                    </div>
                    <div class="mt-2">
                        <div class="flex">
                            <p class="">Bet</p>
                            <input wire:model="bet" required type="number" name="bet" class="ml-2 h-6 w-full rounded-md border border-border bg-content-2 text-center [-moz-appearance:_textfield] [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none" />
                            <button type="submit" class="self-center h-6 ml-2 border border-success rounded-lg bg-success/10 hover:bg-success hover:text-content-1 focus:bg-content-1 focus:text-text-lighter"><span class="material-symbols-outlined">upload</span></button>
                        </div>
                        <p class="mt-1">Multiplier --> <span class="font-semibold">{{$player_multiplier}}</span></p>
                        <p class="mt-1">Player gets --> <span class="font-semibold">{{$player_gets}}</span></p>
                    </div>
                </div>
            </form>
            @if($records->isEmpty())
            <p class="text-text-lighter text-center mt-6">Nothing to see here (yet)</p>
            @else
            <div class="overflow-auto">
                <table class="table-auto w-full mt-2">
                    <thead class="border-b border-text/40">
                        <tr>
                            <th class="text-left p-2">Game</th>
                            <th class="text-left p-2">Class</th>
                            <th class="text-left p-2">Cashout</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-solid divide-text/40">
                        @foreach($records as $record)
                        <tr wire:key="{{ $record->id }}" class="">
                            <td class="p-2">{{$record->game->name}}</td>
                            <td class="p-2">{{$record->class->name}}</td>
                            <td class="p-2">{{$record->player_gets}}</td>
                            <td class="ml-auto text-right">
                                <button wire:click="delete_record({{$record->id}})" class="p-2">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <div class="p-2 mb-10 border border-border rounded-md w-full bg-content-1 lg:col-span-2">
            <div>Bet average: {{$bet_average}}</div>
            <div>Cashout average: {{$cashout_average}}</div>
            <button wire:click="test_insert">Test insert</button>
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