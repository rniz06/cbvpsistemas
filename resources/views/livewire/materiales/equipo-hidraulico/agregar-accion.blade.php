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

                @if (in_array($accion_id, [1, 2]))
                    <div class="col-md-12">
                        <x-adminlte-select name="herramientaSeleccionada" label="Herramientas:"
                            wire:model.live="herramientaSeleccionada">

                            <option value="">Seleccione una acción</option>
                            <option value="0">SOLO MARCAR EQUIPO (NO AFECTAR HERRAMIENTAS)</option>

                            @foreach ($herramientas as $herramienta)
                                <option value="{{ $herramienta->id_hidraulico_herr }}">
                                    {{ $herramienta->tipo->tipo ?? 'S/D' }}
                                </option>
                            @endforeach

                        </x-adminlte-select>
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
