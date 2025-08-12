<div>
    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5><i class="fas fa-check-circle mr-2" style="color: #28a745"></i>{{ $message }}</h5>
        </div>
    @endif

    {{-- Formulario --}}
    @canany(['Cargos Crear', 'Cargos Editar', 'Cargos Eliminar'])
        <x-adminlte-card theme="success" theme-mode="outline">
            <form class="col-md-12 row" wire:submit="grabar">
                {{-- Cargo --}}
                <x-adminlte-input name="cargo" label="Cargo:" placeholder="Cargo..." fgroup-class="col-md-3"
                    oninput="this.value = this.value.toUpperCase()" wire:model.blur="cargo" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />

                {{-- Codigo Cargo --}}
                <x-adminlte-input name="codigo_cargo" label="Código Ej (A1):" placeholder="Código Ej (A1)..." fgroup-class="col-md-3"
                    oninput="this.value = this.value.toUpperCase()" wire:model.blur="codigo_cargo" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />

                {{-- Rango --}}
                <div class="col-md-3">
                    <x-adminlte-select name="rango_id" label="Rangos:" wire:model.blur="rango_id" :disabled="in_array($modo, ['inicio', 'seleccionado'])">
                        <option>-- Seleccionar --</option>
                        @forelse ($rangos as $rango)
                            <option value="{{ $rango->id_rango ?? 'S/D' }}">{{ $rango->rango ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>

                {{-- Botones --}}
                <div class="card-footer">
                    @can('Cargos Crear')
                        <x-adminlte-button type="button" label="Agregar" theme="success" icon="fas fa-lg fa-plus"
                            wire:click="agregar" :disabled="in_array($modo, ['agregar', 'modificar', 'seleccionado'])" />
                    @endcan
                    @can('Cargos Editar')
                        <x-adminlte-button type="button" label="Modificar" theme="warning" icon="fas fa-lg fa-edit"
                            wire:click="editar" :disabled="in_array($modo, ['inicio', 'modificar', 'agregar'])" />
                    @endcan
                    @can('Cargos Eliminar')
                        <x-adminlte-button type="button" label="Eliminar" theme="danger" icon="fas fa-lg fa-trash"
                            id="btn-eliminar" :disabled="in_array($modo, ['agregar', 'modificar', 'inicio'])" />
                    @endcan
                    @canany(['Cargos Crear', 'Cargos Editar'])
                        <x-adminlte-button type="button" label="Grabar" theme="default" icon="fas fa-lg fa-save"
                            id="btn-grabar" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />
                    @endcanany


                    <x-adminlte-button type="button" label="Cancelar" theme="secondary" icon="fas fa-lg fa-window-close"
                        wire:click="cancelar" :disabled="in_array($modo, ['inicio'])" />
                </div>
            </form>
        </x-adminlte-card>
    @endcanany

    <!-- Tabla -->
    <x-tabla titulo="Listado de Cargos Del CBVP" excel pdf>
        <x-slot name="cabeceras">
            <th>
                <div>
                    <x-adminlte-input name="buscarCargo" label="Cargo:" placeholder="Cargo..." fgroup-class="col-md-12"
                        wire:model.live.debounce.250ms="buscarCargo" oninput="this.value = this.value.toUpperCase()" />
                </div>
            </th>
            <th>
                <div>
                    <x-adminlte-input name="buscarCodigoCargo" label="Código:" placeholder="Código..."
                        fgroup-class="col-md-12" wire:model.live.debounce.250ms="buscarCodigoCargo"
                        oninput="this.value = this.value.toUpperCase()" />
                </div>
            </th>
            <th>
                <div>
                    <x-adminlte-select name="buscarRangoId" label="Rango:"
                        wire:model.live.debounce.250ms="buscarRangoId" fgroup-class="col-md-12">
                        <option value="">-- Todos --</option>
                        @forelse ($rangos as $rango)
                            <option value="{{ $rango->id_rango ?? 'S/D' }}">
                                {{ $rango->rango ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>
            </th>
        </x-slot>

        @forelse ($cargos as $cargo)
            <tr wire:click="seleccionado({{ $cargo->id_cargo }})" wire:key="{{ $cargo->id_cargo }}">
                <td>{{ $cargo->cargo ?? 'S/D' }}</td>
                <td>{{ $cargo->codigo_cargo ?? 'S/D' }}</td>
                <td>{{ $cargo->rango ?? 'S/D' }}</td>
            </tr>
        @empty
            <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
        @endforelse

        <x-slot name="paginacion">
            {{ $cargos->links() }}
        </x-slot>
    </x-tabla>

</div>


@push('scripts')
    {{-- Script para boton guardar --}}
    <script>
        const btnGuardar = document.getElementById('btn-grabar');
        if (btnGuardar) {
            btnGuardar.addEventListener('click', function() {
                // Obtener el modo actual directamente de Livewire                 
                const modoActual = @this.get('modo');

                let titulo = modoActual === 'modificar' ? 'MODIFICAR' : 'AGREGAR';
                let mensaje = modoActual === 'modificar' ? '¿DESEAS ACTUALIZAR EL REGISTRO?' :
                    '¿DESEAS GRABAR EL NUEVO REGISTRO?';
                let respuesta = modoActual === 'modificar' ? 'Registro Actualizado Con Éxito' :
                    'Registro Creado Con Éxito';

                Swal.fire({
                    title: titulo,
                    text: mensaje,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#458E49",
                    confirmButtonText: "SI",
                    cancelButtonText: "NO",
                    closeOnConfirm: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.grabar();
                        // Swal.fire({
                        //     title: "Respuesta",
                        //     text: respuesta,
                        //     icon: "success"
                        // });
                    }
                });
            });
        }
    </script>

    {{-- Script para boton eliminar --}}
    <script>
        const btnEliminar = document.getElementById('btn-eliminar');
        if (btnEliminar) {
            btnEliminar.addEventListener('click', function() {
                Swal.fire({
                    title: "ELIMINAR",
                    text: "¿DESEAS ELIMINAR EL REGISTRO SELECCIONADO?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#458E49",
                    confirmButtonText: "SI",
                    cancelButtonText: "NO",
                    closeOnConfirm: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.eliminar();
                        Swal.fire({
                            title: "Respuesta",
                            text: "Registro Eliminado Con Exito",
                            icon: "success"
                        });
                    }
                });
            });
        }
    </script>
@endpush

@push('css')
@endpush
