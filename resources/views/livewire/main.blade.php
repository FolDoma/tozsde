<div wire:poll="get_data" class="w-full h-full p-2 grid grid-cols-2 grid-flow-col">
    <div class="border border-border rounded-md w-full h-full bg-content-1 overflow-hidden">
        <table class="table-auto w-full h-full text-2xl">
            <thead class="p-2 border-b border-text/40 bg-content-2">
                <tr class="">
                    <th class="p-2 text-left">Game</th>
                    <th class="p-2 text-left">Room</th>
                    <th class="p-2 text-right">Multi X</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-solid divide-text/40 p-2">
                @foreach($games as $game)
                <tr wire:key="{{$game->id}}">
                    <td class="p-2">{{$game->name}}</td>
                    <td class="p-2">{{$game->room}}</td>
                    <td class="p-2 text-right">{{$game->manual_multiplier ?? $game->multiplier}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center w-full self-center">
        <p class="text-4xl mb-8">Uj szorzok:</p>
        <p class="text-9xl">9:56</p>
    </div>
</div>