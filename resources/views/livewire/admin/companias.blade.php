<div>
    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5><i class="fas fa-check-circle mr-2" style="color: #28a745"></i>{{ $message }}</h5>
        </div>
    @endif

    {{-- Formulario --}}
    @canany(['Companias Crear', 'Companias Editar', 'Companias Eliminar'])
        <x-adminlte-card theme="success" theme-mode="outline">
            <form class="col-md-12 row" wire:submit="grabar">
                {{-- Compania --}}
                <x-adminlte-input name="compania" label="Compañia:" placeholder="Compañia..." fgroup-class="col-md-3"
                    oninput="this.value = this.value.toUpperCase()" wire:model.blur="compania" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />
                {{-- Ciudad --}}
                <div class="col-md-3">
                    <x-adminlte-select name="ciudad_id" label="Ciudad:" wire:model.blur="ciudad_id" :disabled="in_array($modo, ['inicio', 'seleccionado'])">
                        <option>-- Seleccionar --</option>
                        @forelse ($ciudades as $ciudad)
                            <option value="{{ $ciudad->id_ciudad ?? 'S/D' }}">{{ $ciudad->ciudad ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>
                {{-- Region --}}
                <div class="col-md-3">
                    <x-adminlte-select name="region_id" label="Región:" wire:model.blur="region_id" :disabled="in_array($modo, ['inicio', 'seleccionado'])">
                        <option>-- Seleccionar --</option>
                        @forelse ($regiones as $region)
                            <option value="{{ $region->id_region ?? 'S/D' }}">{{ $region->region ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>
                {{-- Orden --}}
                <x-adminlte-input type="number" name="orden" label="Orden:" placeholder="Orden..."
                    fgroup-class="col-md-3" wire:model.blur="orden" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />

                {{-- Botones --}}
                <div class="card-footer">
                    @can('Companias Crear')
                        <x-adminlte-button type="button" label="Agregar" theme="success" icon="fas fa-lg fa-plus"
                            wire:click="agregar" :disabled="in_array($modo, ['agregar', 'modificar', 'seleccionado'])" />
                    @endcan
                    @can('Companias Editar')
                        <x-adminlte-button type="button" label="Modificar" theme="warning" icon="fas fa-lg fa-edit"
                            wire:click="editar" :disabled="in_array($modo, ['inicio', 'modificar', 'agregar'])" />
                    @endcan
                    @can('Companias Eliminar')
                        <x-adminlte-button type="button" label="Eliminar" theme="danger" icon="fas fa-lg fa-trash"
                            id="btn-eliminar" :disabled="in_array($modo, ['agregar', 'modificar', 'inicio'])" />
                    @endcan
                    @canany(['Companias Crear', 'Companias Editar'])
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
    <x-tabla titulo="Listado de Compañias" excel pdf>
        <x-slot name="cabeceras">
            <th>
                <div>
                    <x-adminlte-input name="buscarCompania" label="Compañia:" placeholder="Compañia..."
                        fgroup-class="col-md-12" wire:model.live.debounce.250ms="buscarCompania"
                        oninput="this.value = this.value.toUpperCase()" />
                </div>
            </th>
            <th>
                <div>
                    <x-adminlte-select name="buscarDepartamentoId" label="Departamento:"
                        wire:model.live.debounce.250ms="buscarDepartamentoId" fgroup-class="col-md-12">
                        <option value="">-- Todos --</option>
                        @forelse ($departamentos as $departamento)
                            <option value="{{ $departamento->id_departamento ?? 'S/D' }}">
                                {{ $departamento->departamento ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>
            </th>
            <th>
                <div>
                    <x-adminlte-select name="buscarCiudadId" label="Ciudad:"
                        wire:model.live.debounce.250ms="buscarCiudadId" fgroup-class="col-md-12">
                        <option value="">-- Todos --</option>
                        @forelse ($ciudades as $ciudad)
                            <option value="{{ $ciudad->id_ciudad ?? 'S/D' }}">{{ $ciudad->ciudad ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>
            </th>
            <th>
                <div>
                    <x-adminlte-select name="buscarRegionId" label="Región:"
                        wire:model.live.debounce.250ms="buscarRegionId" fgroup-class="col-md-12">
                        <option value="">-- Todos --</option>
                        @forelse ($regiones as $region)
                            <option value="{{ $region->id_region ?? 'S/D' }}">{{ $region->region ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>
            </th>
        </x-slot>

        @foreach ($companias as $compania)
            <tr wire:click="seleccionado({{ $compania->id_compania }})" wire:key="{{ $compania->id_compania }}">
                <td>{{ $compania->compania ?? 'S/D' }}</td>
                <td>{{ $compania->departamento ?? 'S/D' }}</td>
                <td>{{ $compania->ciudad ?? 'S/D' }}</td>
                <td>{{ $compania->region ?? 'S/D' }}</td>
            </tr>
        @endforeach

        <x-slot name="paginacion">
            {{ $companias->links() }}
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
