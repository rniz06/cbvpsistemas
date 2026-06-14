<div class="d-inline">

    <button
        class="btn btn-warning btn-sm"
        data-bs-toggle="collapse"
        data-bs-target="#edit{{ $llamado->id }}"
    >
        Editar
    </button>

    <div
        class="collapse mt-2"
        id="edit{{ $llamado->id }}"
    >

        <form wire:submit="save">

            <input
                type="text"
                wire:model="llamado.nombre"
                class="form-control mb-2"
            >

            <input
                type="number"
                wire:model="llamado.anio"
                class="form-control mb-2"
            >

            <button
                class="btn btn-primary btn-sm"
            >
                Guardar
            </button>

        </form>

    </div>

</div>