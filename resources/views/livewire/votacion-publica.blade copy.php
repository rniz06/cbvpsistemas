<div>
    <div wire:poll.2s class="grid grid-cols-3 gap-4 p-4">
        @foreach($mesas as $mesa)
            <div class="p-4 bg-white rounded shadow text-center">
                <h3 class="text-lg font-semibold">{{ $mesa->mesa }}</h3>
                <p class="text-2xl font-bold">{{ $mesa->votos }}</p>
            </div>
        @endforeach
    </div>
</div>
