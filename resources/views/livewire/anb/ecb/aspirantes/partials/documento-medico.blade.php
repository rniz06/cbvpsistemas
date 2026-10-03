<div class="col-md-12">

    <div class="d-flex justify-content-between align-items-start py-3 px-2 border-bottom">

        {{-- IZQUIERDA --}}
        <div style="flex:1;">

            <div class="font-weight-bold mb-2">

                {{ $titulo }}

                @if($opcional)

                    <span class="badge badge-secondary ml-1">
                        Opcional
                    </span>

                @endif

            </div>

            {{-- SOLO PARA LA FICHA MÉDICA --}}
            @if($campo=='ficha_medica_archivo')

                <div class="mb-3" style="max-width:380px;">

                    <label class="small text-muted font-weight-bold">

                        MÉDICO FIRMANTE

                    </label>

                    <div class="input-group">

                        <div class="input-group-prepend">

                            <span class="input-group-text">

                                <i class="fas fa-user-md"></i>

                            </span>

                        </div>

                        <input
                            wire:model="registro_medico"
                            class="form-control"
                            placeholder="Ej: Registro MSPBS Nº 12.345"
                        >

                    </div>

                </div>

            @endif

            <small class="text-muted d-block mb-2">

                @if($aspirante->fichaMedica?->$campo)

                    <i class="fas fa-file-alt text-success mr-1"></i>

                    Documento cargado correctamente.

                @else

                    <i class="fas fa-file-alt text-muted mr-1"></i>

                    @if($opcional)

                        Documento opcional no cargado.

                    @else

                        Documento pendiente de carga.

                    @endif

                @endif

            </small>

            {{-- ==============================
                 PREVISUALIZACIÓN
            =============================== --}}

            @php

                $archivoTemporal = $this->$campo;

            @endphp

            @if($archivoTemporal)

                <div class="alert alert-info py-2">

                    <i class="fas fa-check-circle text-success"></i>

                    <strong>

                        Archivo seleccionado:

                    </strong>

                    {{ $archivoTemporal->getClientOriginalName() }}

                </div>

                @if(str_starts_with($archivoTemporal->getMimeType(),'image/'))

                    <img
                        src="{{ $archivoTemporal->temporaryUrl() }}"
                        class="img-thumbnail mt-2"
                        style="
                            max-height:220px;
                            max-width:100%;
                        "
                    >

                @endif

            @endif

            {{-- ==============================
                 SUBIENDO...
            =============================== --}}

            <div
                wire:loading
                wire:target="{{ $campo }}"
                class="mt-2 text-primary"
            >

                <i class="fas fa-spinner fa-spin"></i>

                Subiendo archivo...

            </div>

        </div>

        {{-- DERECHA --}}
        <div class="text-right ml-3">

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

                        <i class="fas fa-eye"></i>

                        Ver

                    </a>

                    <label class="btn btn-outline-secondary mb-0">

                        <i class="fas fa-upload"></i>

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

                        <i class="fas fa-trash"></i>

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

                    <i class="fas fa-upload"></i>

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