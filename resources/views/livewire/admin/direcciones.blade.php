<div>
    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5><i class="fas fa-check-circle mr-2" style="color: #28a745"></i>{{ $message }}</h5>
        </div>
    @endif

    {{-- Formulario --}}
    @canany(['Direcciones Crear', 'Direcciones Editar', 'Direcciones Eliminar'])
        <x-adminlte-card theme="success" theme-mode="outline">
            <form class="col-md-12 row" wire:submit="grabar">
                {{-- Direccion --}}
                <x-adminlte-input name="direccion" label="Dirección:" placeholder="Dirección..." fgroup-class="col-md-6"
                    oninput="this.value = this.value.toUpperCase()" wire:model.blur="direccion" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />

                {{-- Compania --}}
                <div class="col-md-6">
                    <x-adminlte-select name="compania_id" label="Pertenece a:" wire:model.blur="compania_id" :disabled="in_array($modo, ['inicio', 'seleccionado'])">
                        <option>-- Seleccionar --</option>
                        @forelse ($companias as $compania)
                            <option value="{{ $compania->id_compania ?? 'S/D' }}">{{ $compania->compania ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>

                {{-- Botones --}}
                <div class="card-footer">
                    @can('Direcciones Crear')
                        <x-adminlte-button type="button" label="Agregar" theme="success" icon="fas fa-lg fa-plus"
                            wire:click="agregar" :disabled="in_array($modo, ['agregar', 'modificar', 'seleccionado'])" />
                    @endcan
                    @can('Direcciones Editar')
                        <x-adminlte-button type="button" label="Modificar" theme="warning" icon="fas fa-lg fa-edit"
                            wire:click="editar" :disabled="in_array($modo, ['inicio', 'modificar', 'agregar'])" />
                    @endcan
                    @can('Direcciones Eliminar')
                        <x-adminlte-button type="button" label="Eliminar" theme="danger" icon="fas fa-lg fa-trash"
                            id="btn-eliminar" :disabled="in_array($modo, ['agregar', 'modificar', 'inicio'])" />
                    @endcan
                    @canany(['Direcciones Crear', 'Direcciones Editar'])
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
    <x-tabla titulo="Listado de Direcciones del CBVP" excel pdf>
        <x-slot name="cabeceras">
            <th>
                <div>
                    <x-adminlte-input name="buscarDireccion" label="Dirección:" placeholder="Dirección..."
                        fgroup-class="col-md-12" wire:model.live.debounce.250ms="buscarDireccion"
                        oninput="this.value = this.value.toUpperCase()" />
                </div>
            </th>
            <th>
                <div>
                    <x-adminlte-select name="buscarCompaniaId" label="Pertenece a:"
                        wire:model.live.debounce.250ms="buscarCompaniaId" fgroup-class="col-md-12">
                        <option>-- Seleccionar --</option>
                        @forelse ($companias as $compania)
                            <option value="{{ $compania->id_compania ?? 'S/D' }}">{{ $compania->compania ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>
            </th>
        </x-slot>

        @forelse ($direcciones as $direccion)
            <tr wire:click="seleccionado({{ $direccion->id_direccion }})" wire:key="{{ $direccion->id_direccion }}">
                <td>{{ $direccion->direccion ?? 'S/D' }}</td>
                <td>{{ $direccion->compania ?? 'S/D' }}</td>
            </tr>
        @empty
            <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
        @endforelse

        <x-slot name="paginacion">
            {{ $direcciones->links() }}
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
