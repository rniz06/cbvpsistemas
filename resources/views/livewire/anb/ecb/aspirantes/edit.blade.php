<div>

    <button
        class="btn btn-warning btn-sm"
        data-bs-toggle="collapse"
        data-bs-target="#edit{{ $aspirante->id }}"
    >

        Editar

    </button>

    <div
        class="collapse mt-2"
        id="edit{{ $aspirante->id }}"
    >

        <form wire:submit.prevent="save">

            <input
                wire:model="aspirante.nombre"
                class="form-control mb-2"
            >

            <input
                wire:model="aspirante.apellido"
                class="form-control mb-2"
            >

            <button
                type="submit"
                class="btn btn-success btn-sm"
            >

                Guardar

            </button>

        </form>

    </div>

</div>