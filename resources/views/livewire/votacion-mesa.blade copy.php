<div class="card shadow-sm border-0">
    <div class="card-body">
        <h4 class="card-title mb-2">{{ $mesa->mesa ?? 'N/A' }}</h4>
        <p class="card-text text-muted">Votos actuales: <span class="fw-bold">{{ $mesa->votos }}</span></p>

        <div class="d-grid gap-2 my-4">
            <button wire:click="agregarUno" class="btn btn-success">
                +1 Voto
            </button>
        </div>

        <div class="input-group mt-3">
            <input type="number" wire:model="cantidad" min="1" class="form-control" placeholder="Cantidad a agregar">
            <button wire:click="agregarCantidad" class="btn btn-success">
                Agregar
            </button>
        </div>
    </div>
</div>
