<form wire:submit.prevent="guardar" class="row">
    {{-- Fila 1: Datos del Responsable --}}
    <div class="card card-primary col-md-12">
        <div class="card-header bg-light p-1">
            <h6 class="card-title">Datos del Responsable</h6>
        </div>
        <div class="card-body p-1 m-0">
            <div class="row">
                {{-- Selec Operatividad --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="text-black">
                            Cia Operatividad? *
                        </label>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="cca_operativo"
                                wire:model.live="cca_operativo">

                            <label class="custom-control-label" for="cca_operativo">
                                @if ($cca_operativo)
                                    <span class="text-success">
                                        🟢 Operativo
                                    </span>
                                @else
                                    <span class="text-danger">
                                        🔴 Inoperativo
                                    </span>
                                @endif
                            </label>
                        </div>

                        @error('cca_operativo')
                            <span class="text-danger text-sm">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- A cargo --}}
                <x-adminlte-input name="acargo" wire:model.blur="acargo"
                    oninput="this.value = this.value.toUpperCase()" placeholder="Ej: C151 o 8699"
                    label-class="text-lightblue" fgroup-class="col-md-4">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">A cargo *</div>
                    </x-slot>
                </x-adminlte-input>

                {{-- Personal --}}
                <x-adminlte-input name="cant_personal" wire:model.blur="cant_personal" type="number"
                    placeholder="Ej: 1 o 5" label-class="text-lightblue" fgroup-class="col-md-4">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">Personal *</div>
                    </x-slot>
                </x-adminlte-input>
            </div>
        </div>
    </div>

    {{-- Fila 2: Dotación, Móviles y Equipamiento Principal --}}
    <div class="card card-primary col-md-12">
        <div class="card-header bg-light p-1">
            <h6 class="card-title">Dotación y Móviles</h6>
        </div>
        <div class="card-body p-1 m-0">
            <div class="row">
                {{-- Conductores --}}
                <x-adminlte-input name="cant_conductor" wire:model.blur="cant_conductor" type="number"
                    placeholder="Ej: 1 o 5" label-class="text-lightblue" fgroup-class="col-md-4">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">Conductores *</div>
                    </x-slot>
                </x-adminlte-input>

                {{-- Equipo Hidráulico --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="text-black">
                            E. Hidráulico *
                        </label>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="equipo_hidraulico"
                                wire:model.live="equipo_hidraulico">

                            <label class="custom-control-label" for="equipo_hidraulico">
                                @if ($equipo_hidraulico)
                                    <span class="text-success">
                                        🟢 Operativo
                                    </span>
                                @else
                                    <span class="text-danger">
                                        🔴 Inoperativo
                                    </span>
                                @endif
                            </label>
                        </div>

                        @error('equipo_hidraulico')
                            <span class="text-danger text-sm">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>


                {{-- Pileta --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="text-black">
                            Pileta *
                        </label>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="pileta" wire:model.live="pileta">

                            <label class="custom-control-label" for="pileta">
                                @if ($pileta)
                                    <span class="text-success">
                                        🟢 Operativo
                                    </span>
                                @else
                                    <span class="text-danger">
                                        🔴 Inoperativo
                                    </span>
                                @endif
                            </label>
                        </div>

                        @error('pileta')
                            <span class="text-danger text-sm">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- Autónomo --}}
                <x-adminlte-input name="cant_autonomo" wire:model.blur="cant_autonomo" type="number"
                    placeholder="Ej: 1 o 12" label-class="text-lightblue" fgroup-class="col-md-6">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">Autónomo *</div>
                    </x-slot>
                </x-adminlte-input>

                {{-- Espuma --}}
                <x-adminlte-input name="cant_espuma" wire:model.blur="cant_espuma" type="number"
                    placeholder="Ej: 1 o 12" label-class="text-lightblue" fgroup-class="col-md-6">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">Espuma *</div>
                    </x-slot>
                    <x-slot name="bottomSlot">
                        <span class="text-sm text-gray">
                            [Cantidad de espuma en litros]
                        </span>
                    </x-slot>
                </x-adminlte-input>

                <div class="col-md-12 text-center">
                    <h5>Listado de Móviles</h5>
                </div>

                <div class="d-flex flex-wrap col-md-12">
                    @forelse ($movilesSelect as $movil)
                        <div class="form-check m-0 col-md-2">
                            <input class="form-check-input" type="checkbox" name="moviles[]" wire:model.live="moviles"
                                id="movilId-{{ $movil->id_movil ?? 'S/D' }}" value="{{ $movil->id_movil ?? 'S/D' }}">
                            <label class="form-check-label" for="movilId-{{ $movil->id_movil ?? 'S/D' }}">
                                {{ $movil->acronimo->tipo ?? 'S/D' }}-{{ $movil->movil ?? 'S/D' }}
                            </label>
                        </div>
                    @empty
                        <div class="w-100">
                            <p class="text-muted">Sin registro de moviles</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="col-md-12">{{ $ult_reg_operatividad ?? 's-d' }}</div> --}}



    {{-- <div class="badge badge-success"> : {{  print_r($moviles) }}</div> --}}
    <div class="modal-footer col-md-12">
        <x-adminlte-button type="submit" theme="outline-success" icon="fas fa-save" class="btn-sm col-md-6"
            label="Guardar" />
        <x-adminlte-button theme="outline-secondary" label="Cerrar" icon="fas fa-window-close"
            class="btn-sm col-md-5" data-dismiss="modal" wire:click="resetForm" />
    </div>
</form>
