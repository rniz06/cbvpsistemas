<div>
    <!-- Formulario para Agregar Accion Equipo Hidraulico -->
    <form wire:submit="guardar">

        <x-adminlte-card title="Agregar Acción" icon="fas fa-plus" theme-mode="outline" header-class="bg-success">

            <div class="row align-items-end">
                {{-- CAMPO ACCION --}}
                <div class="col-md-4">
                    <x-adminlte-select name="accion_id" label="Acción:" wire:model.live="accion_id">
                        <option value="">Seleccione una acción</option>
                        <option value="1">EN SERVICIO</option>
                        <option value="2">FUERA DE SERVICIO</option>
                        <option value="3">REPORTAR NOVEDAD</option>
                    </x-adminlte-select>
                </div>

                <div class="col-md-8">
                    {{-- Minimal --}}
                    <x-adminlte-textarea name="comentario" oninput="this.value = this.value.toUpperCase()"
                        label="Comentario:" wire:model.live="comentario" placeholder="Comentario..." rows=1 />
                </div>

                {{-- FUERA DE SERVICION -> MOSTRAR LAS HERRAMIENTAS --}}
                @if ($accion_id == 2)
                    <div class="col-md-12">
                        <h5>Herramientas (Marcar para pasar a inoperativo):</h5>
                        @foreach ($herramientas as $herramienta)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="herramientasSeleccionadas"
                                    value="{{ $herramienta->id_hidraulico_herr }}"
                                    id="herr_{{ $herramienta->id_hidraulico_herr }}">
                                <label class="form-check-label" for="defaultCheck1">
                                    {{ $herramienta->tipo->tipo ?? 'S/D' }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

            <x-slot name="footerSlot">
                {{-- BOTON DE GUARDADO --}}
                <x-adminlte-button label="Guardar" icon="fas fa-save" type="submit" theme="success" class="mb-3" />
            </x-slot>

        </x-adminlte-card>
    </form>
</div>
