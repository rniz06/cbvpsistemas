<div wire:transition.duration.500ms>
    <!-- Formulario para Agregar Comentario -->
    <form wire:submit="guardar">

        <x-adminlte-card title="Agregar Apoyo" icon="fas fa-plus" theme-mode="outline" header-class="bg-success">

            <div class="row align-items-end">

                {{-- Compania --}}
                <div class="col-md-2">
                    <x-adminlte-select name="compania_id" label="Compañia:" wire:model.blur="compania_id">
                        <option>Seleccionar...</option>
                        @forelse ($companias as $compania)
                            <option value="{{ $compania->id_compania ?? 'null' }}">{{ $compania->compania ?? 'S/D' }}
                            </option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>

                {{-- Compania --}}
                <div class="col-md-2">
                    <x-adminlte-select name="movil_id" label="Móvil:" wire:model.blur="movil_id">
                        <option value="" disabled selected>Seleccionar...</option>
                        @forelse ($moviles as $movil)
                            <option value="{{ $movil->id_movil ?? 'null' }}">
                                {{ $movil->tipo . '-' . $movil->movil ?? 'S/D' }}
                            </option>
                        @empty
                        @endforelse
                    </x-adminlte-select>
                </div>

                {{-- Acargo --}}
                <x-adminlte-input name="acargo" type="numeric" label="A cargo:" wire:model.blur="acargo"
                    fgroup-class="col-md-2" />

                {{-- chofer --}}
                <x-adminlte-input name="chofer" label="Chofer:" wire:model.blur="chofer" fgroup-class="col-md-2" />

                {{-- Cantidad Tripulantes --}}
                <x-adminlte-input name="cantidad_tripulantes" type="numeric" label="Tripulantes:"
                    wire:model.blur="cantidad_tripulantes" fgroup-class="col-md-2" />

                {{-- BOTON DE GUARDADO --}}
                <div class="col-md-2">
                    <x-adminlte-button label="Guardar" icon="fas fa-save" type="submit" theme="success"
                        class="mb-3" />
                </div>
            </div>

        </x-adminlte-card>
    </form>
</div>
