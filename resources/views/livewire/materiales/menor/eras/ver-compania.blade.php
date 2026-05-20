<div>
    {{-- Do your work, then step back. --}}
    <h4>Ficha de Compañia: {{ $compania->compania ?? 'S/D' }}
        @can('Material Menor Crear')
            - <x-adminlte-button theme="outline-success" :label="$ver_form_alta ? 'Cerrar Formulario' : 'Añadir Item'" class="btn-sm" :icon="$ver_form_alta ? 'fas fa-times' : 'fas fa-plus'"
                wire:click="$toggle('ver_form_alta')" /></h4>
    @endcan

    @if ($ver_form_alta)
        <br>
        <div class="col-md-12">
            @livewire('materiales.menor.eras.create', ['companiaId' => $compania->id_compania])
        </div>
    @endif

    {{-- MODAL COMPONENTE DE ACTUALIZACION --}}
    <x-adminlte-modal id="modal-actualizar" title="Actualizar Registro" theme="light" icon="fas fa-edit" v-centered
        static-backdrop size="xl">
        @if ($item)
            @livewire('materiales.menor.eras.edit', ['item' => $item], key('modal-edit' . $item))
        @endif
        <x-slot name="footerSlot"></x-slot>
    </x-adminlte-modal>

    {{-- MODAL COMPONENTE VER COMENTARIOS --}}
    <x-adminlte-modal id="modal-ver-comentarios" title="Historial de Movimientos" theme="light" icon="fas fa-list-ul"
        v-centered static-backdrop size="xl">
        @if ($item)
            @livewire('materiales.menor.eras.ver-comentarios', ['item' => $item], key('modal-ver-comentarios' . $item))
        @endif
        <x-slot name="footerSlot"></x-slot>
    </x-adminlte-modal>

    <div class="row">
        {{-- ITEMS MENOR --}}
        <div class="col-md-12">
            <x-table.tabla titulo="Eras" dropdown_direccion="dropleft">

                <x-slot name="encabezados">
                    {{-- NUMERO EN LA FILA --}}
                    <th style="width: 10px">N°</th>

                    {{-- NOMBRE --}}
                    <th>Item</th>

                    {{-- MARCA --}}
                    <th>Marca</th>

                    {{-- CANTIDAD DE OPERATIVOS --}}
                    <th>Cant. Operativos</th>

                    {{-- CANTIDAD DE INOPERATIVOS --}}
                    <th>Cant. Inoperativos</th>

                    {{-- CANTIDAD TOTAL --}}
                    <th>Cant. Total</th>

                    <th>Acciones</th>

                </x-slot>

                @forelse ($eras as $item)
                    <tr>
                        <td>{{ $loop->iteration + $eras->firstItem() - 1 }}</td>
                        <td>{{ $item->componente->nombre ?? 'S/D' }}</td>
                        <td>{{ $item->marca->nombre ?? 'S/D' }}</td>
                        <td><span class="badge badge-success">{{ $item->cantidad_operativo ?? 'S/D' }}</span></td>
                        <td><span class="badge badge-danger">{{ $item->cantidad_inoperativo ?? 'S/D' }}</span></td>
                        <td><span class="badge badge-secondary">{{ $item->cantidad_total ?? 'S/D' }}</span></td>
                        <td>
                            <x-tabla-dropdown>
                                @can('Material Menor Ver')
                                    <x-adminlte-button label="Ver Movimientos" icon="fas fa-eye"
                                        class="dropdown-item btn-sm" data-toggle="modal"
                                        data-target="#modal-ver-comentarios"
                                        wire:click="abrirModalVerComentarios({{ $item->id_menor_item }})" />
                                @endcan

                                @can('Material Menor Editar')
                                    <x-adminlte-button label="Actualizar" icon="fas fa-edit" class="dropdown-item btn-sm"
                                        data-toggle="modal" data-target="#modal-actualizar"
                                        wire:click="abrirModalEdit({{ $item->id_menor_item }})" />
                                @endcan
                            </x-tabla-dropdown>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                        </td>
                    </tr>
                @endforelse

                <x-slot name="paginacion">
                    {{ $eras->links() }}
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
            // new SlimSelect({
            //     select: '#componente_id'
            // })

            // new SlimSelect({
            //     select: '#marca_id'
            // })
        });
    </script>
@endpush
