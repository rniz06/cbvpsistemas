<div>
    {{-- Do your work, then step back. --}}
    <h4>Ficha de Compañia: {{ $compania->compania ?? 'S/D' }} - <x-adminlte-button theme="outline-success"
            :label="$ver_form_alta ? 'Cerrar Formulario' : 'Añadir Item'" class="btn-sm" :icon="$ver_form_alta ? 'fas fa-times' : 'fas fa-plus'" wire:click="$toggle('ver_form_alta')" /></h4>

    @if ($ver_form_alta)
        <br>
        <div class="col-md-12">
            @livewire('materiales.menor.create', ['companiaId' => $compania->id_compania])
        </div>
    @endif

    @if ($ver_form_edicion and $item_id)
        <br>
        <div class="col-md-12">
            @livewire('materiales.menor.menor.edit', ['item' => $item_id])

        </div>
    @endif

    <div class="row">
        {{-- ITEMS MENOR --}}
        <div class="col-md-6">
            <x-table.tabla titulo="Material Menor" dropdown_direccion="dropleft" paginado="paginadoMenor">

                @can('Material Menor Crear')
                    <x-slot name="acciones">
                        <x-adminlte-button :label="$ver_form_alta ? 'Cerrar Formulario' : 'Añadir Item'" class="btn-sm dropdown-item" :icon="$ver_form_alta ? 'fas fa-times' : 'fas fa-plus'"
                            wire:click="$toggle('ver_form_alta')" />
                    </x-slot>
                @endcan

                <x-slot name="encabezados">
                    {{-- NUMERO EN LA FILA --}}
                    <th style="width: 10px">N°</th>

                    {{-- NOMBRE --}}
                    <th>Nombre</th>

                    {{-- CATEGORIA --}}
                    <th>Categoria</th>

                    {{-- CANTIDAD DE OPERATIVOS --}}
                    <th>Cant. Operativos</th>

                    {{-- CANTIDAD DE INOPERATIVOS --}}
                    <th>Cant. Inoperativos</th>

                    @can('Material Menor Ver')
                        <th>Acciones</th>
                    @endcan

                </x-slot>

                @forelse ($menor as $item)
                    <tr>
                        <td>{{ $loop->iteration + $menor->firstItem() - 1 }}</td>
                        <td>{{ $item->componente->nombre ?? 'S/D' }}</td>
                        <td>{{ $item->componente->categoria->nombre ?? 'S/D' }}</td>
                        <td><span class="badge badge-success">{{ $item->cantidad_operativo ?? 'S/D' }}</span></td>
                        <td><span class="badge badge-danger">{{ $item->cantidad_inoperativo ?? 'S/D' }}</span></td>
                        @can('Material Menor Editar')
                            <td>
                                @if ($ver_form_edicion == false)
                                    <x-adminlte-button theme="outline-warning" label="Actualizar" class="btn-sm"
                                        icon="fas fa-edit" wire:click="form_edicion({{ $item->id_menor_item }})" />
                                @endif

                                @if ($ver_form_edicion == true)
                                    <x-adminlte-button theme="outline-warning" label="Cerrar" class="btn-sm"
                                        icon="fas fa-times" wire:click="form_edicion_cerrar" />
                                @endif
                            </td>
                        @endcan
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                        </td>
                    </tr>
                @endforelse

                <x-slot name="paginacion">
                    {{ $menor->links() }}
                </x-slot>
            </x-table.tabla>
        </div>

        {{-- ITEMS FORESTALES --}}
        <div class="col-md-6">
            <x-table.tabla titulo="Equipos Forestales" dropdown_direccion="dropleft" paginado="paginadoForestales">

                @can('Material Menor Crear')
                    <x-slot name="acciones">
                        <x-adminlte-button :label="$ver_form_alta ? 'Cerrar Formulario' : 'Añadir Item'" class="btn-sm dropdown-item" :icon="$ver_form_alta ? 'fas fa-times' : 'fas fa-plus'"
                            wire:click="$toggle('ver_form_alta')" />
                    </x-slot>
                @endcan

                <x-slot name="encabezados">
                    {{-- NUMERO EN LA FILA --}}
                    <th style="width: 10px">N°</th>

                    {{-- NOMBRE --}}
                    <th>Nombre</th>

                    {{-- CANTIDAD DE OPERATIVOS --}}
                    <th>Cant. Operativos</th>

                    {{-- CANTIDAD DE INOPERATIVOS --}}
                    <th>Cant. Inoperativos</th>

                    @can('Material Menor Ver')
                        <th>Acciones</th>
                    @endcan

                </x-slot>

                @forelse ($forestales as $item)
                    <tr>
                        <td>{{ $loop->iteration + $menor->firstItem() - 1 }}</td>
                        <td>{{ $item->componente->nombre ?? 'S/D' }}</td>
                        <td><span class="badge badge-success">{{ $item->cantidad_operativo ?? 'S/D' }}</span></td>
                        <td><span class="badge badge-danger">{{ $item->cantidad_inoperativo ?? 'S/D' }}</span></td>
                        @can('Material Menor Editar')
                            <td>
                                @if ($ver_form_edicion == false)
                                    <x-adminlte-button theme="outline-warning" label="Actualizar" class="btn-sm"
                                        icon="fas fa-edit" wire:click="form_edicion({{ $item->id_menor_item }})" />
                                @endif

                                @if ($ver_form_edicion == true)
                                    <x-adminlte-button theme="outline-warning" label="Cerrar" class="btn-sm"
                                        icon="fas fa-times" wire:click="form_edicion_cerrar" />
                                @endif
                            </td>
                        @endcan
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                        </td>
                    </tr>
                @endforelse

                <x-slot name="paginacion">
                    {{ $menor->links() }}
                </x-slot>
            </x-table.tabla>
        </div>
    </div>
</div>


@push('styles')
    <link rel="stylesheet" href="{{ asset('css/slimselect.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/slimselect.js') }}"></script>

    <script>
        // RECIBIR EVENTO DEL COMPONENTE HIJO Y ACTIVAR LOS SELECTS
        Livewire.on('ver-form-alta', () => {
            // alert('Funciona');
            new SlimSelect({
                select: '#componente_id'
            })

            // new SlimSelect({
            //     select: '#marca_id'
            // })
        });
    </script>
@endpush
