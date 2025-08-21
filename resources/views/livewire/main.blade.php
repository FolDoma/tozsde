<div wire:poll="get_data" class="w-full h-full p-2 grid grid-cols-3 grid-flow-col">
    <div class="border border-border rounded-md w-full h-full bg-content-1 overflow-hidden col-span-2">
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
        <p wire:ignore id="countdown" class="text-6xl">0:00</p>
    </div>

    <script>
        // Only start the timer once
        if (!window.countdownStarted) {
            window.countdownStarted = true;

            // Get the backend time (ISO 8601 string)
            var calculateTime = "{{ $calculate_time }}";

            // Compute the target time (+5 minutes)
            var countDownDate = new Date(calculateTime).getTime() + 5 * 60 * 1000;

            function updateTimer() {
                var now = new Date().getTime();
                var distance = countDownDate - now;

                if (distance <= 0) {
                    // Stop timer
                    clearInterval(x);
                    // Refresh page when countdown reaches 0
                    window.location.reload();
                    return;
                }

                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("countdown").textContent =
                    minutes + ":" + String(seconds).padStart(2, '0');
            }

            // Initial call
            updateTimer();

            // Update every second
            var x = setInterval(updateTimer, 1000);
        }
    </script>

    <script>
        // Listen for the Livewire browser event
        window.addEventListener('reload-page', () => {
            location.reload(); // reload the page when event is triggered
        });
    </script>
</div>