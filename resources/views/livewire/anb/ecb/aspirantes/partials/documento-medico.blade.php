<div class="col-md-12">

    <div class="d-flex justify-content-between align-items-center py-3 px-2 border-bottom">

        <div>

            <div class="font-weight-bold">

                {{ $titulo }}

                @if($opcional)
                    <span class="badge badge-secondary ml-1">
                        Opcional
                    </span>
                @endif

            </div>

            <small class="text-muted">

                @if($aspirante->fichaMedica?->$campo)

                    Documento cargado correctamente

                @else

                    @if($opcional)

                        Documento opcional no cargado

                    @else

                        Documento pendiente de carga

                    @endif

                @endif

            </small>

        </div>

        <div class="text-right">

            @if($aspirante->fichaMedica?->$campo)

                <span class="badge badge-success mb-2">
                    Cargado
                </span>

                <br>

                <div class="btn-group btn-group-sm">

                    <a
                        href="{{ Storage::url($aspirante->fichaMedica->$campo) }}"
                        target="_blank"
                        class="btn btn-outline-primary"
                    >
                        Ver
                    </a>

                    <label class="btn btn-outline-secondary mb-0">

                        Cambiar

                        <input
                            type="file"
                            wire:model="{{ $campo }}"
                            hidden
                        >

                    </label>

                    <button
                        type="button"
                        class="btn btn-outline-danger"
                        wire:click="eliminarArchivo('{{ $campo }}')"
                    >
                        Eliminar
                    </button>

                </div>

            @else

                @if($opcional)

                    <span class="badge badge-secondary mb-2">
                        No cargado
                    </span>

                @else

                    <span class="badge badge-danger mb-2">
                        Pendiente
                    </span>

                @endif

                <br>

                <label class="btn btn-primary btn-sm mb-0">

                    Subir documento

                    <input
                        type="file"
                        wire:model="{{ $campo }}"
                        hidden
                    >

                </label>

            @endif

        </div>

    </div>

</div>