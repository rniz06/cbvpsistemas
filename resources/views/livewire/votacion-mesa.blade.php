<div class="card shadow-sm border-0">
    <div class="card-body">
        <h4 class="card-title mb-2">Mesa {{ $mesa->mesa ?? 'N/A' }}</h4>

        <p class="card-text text-muted">
            Total votos: 
            <span class="fw-bold">
                {{ $mesa->personales->sum('pivot.votos') }}
            </span>
        </p>

        <hr>

        @foreach ($personales as $personal)
            <div class="mb-4">
                <h5 class="card-title">{{ $personal->nombrecompleto }}</h5>
                <p class="card-text text-muted">Votos actuales: <span class="fw-bold">{{ $personal->pivot->votos }}</span></p>

                <div class="d-grid gap-2 my-2">
                    <button wire:click="agregarUno({{ $personal->idpersonal }})" class="btn btn-success">
                        +1 Voto
                    </button>
                </div>

                <div class="input-group mt-2">
                    <input type="number" wire:model="cantidad.{{ $personal->idpersonal }}" min="1" class="form-control" placeholder="Cantidad a agregar">
                    <button wire:click="agregarCantidad({{ $personal->idpersonal }})" class="btn btn-primary">
                        Agregar
                    </button>
                </div>

                <hr>
            </div>
        @endforeach

        <div class="d-grid mt-4">
            <a href="{{ route('mesas.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </div>
    </div>
</div>
