<div>
    {{-- MODAL COMPONENTE DE ACTUALIZACION --}}
    <x-adminlte-modal id="modal-actualizar" title="Actualizar Registro" theme="light" icon="fas fa-edit" v-centered
        static-backdrop size="lg">
        @if ($item)
            @livewire('materiales.menor.edit', ['item' => $item], key('modal-edit' . $item))
        @endif
        <x-slot name="footerSlot"></x-slot>
    </x-adminlte-modal>

    {{-- MODAL COMPONENTE VER COMENTARIOS --}}
    <x-adminlte-modal id="modal-ver-comentarios" title="Historil de Movimientos" theme="light" icon="fas fa-list-ul"
        v-centered static-backdrop size="xl">
        @if ($item)
            @livewire('materiales.menor.ver-comentarios', ['item' => $item], key('modal-ver-comentarios' . $item))
        @endif
        <x-slot name="footerSlot"></x-slot>
    </x-adminlte-modal>

    <div class="row col-md-12">
        <div class="col-md-6">
            <x-table.tabla titulo="Material Menor" paginado="paginadoMenor">

                <x-slot name="encabezados">
                    <th>#</th>
                    <th>Item</th>
                    <th>Categoria</th>
                    <th>Cant. Operativos</th>
                    <th>Cant. Inoperativos</th>
                    <th>Compañia</th>
                    <th>Acciones</th>
                </x-slot>

                @forelse ($menor as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <th>{{ $item->componente->nombre ?? 'S/D' }}</th>
                        <th>{{ $item->componente->categoria->nombre ?? 'S/D' }}</th>
                        <th>{{ $item->cantidad_operativo ?? 'S/D' }}</th>
                        <th>{{ $item->cantidad_inoperativo ?? 'S/D' }}</th>
                        <th>{{ $item->compania->compania ?? 'S/D' }}</th>
                        <th>
                            <x-tabla-dropdown>
                                <x-adminlte-button label="Ver Movimientos" icon="fas fa-eye"
                                    class="dropdown-item btn-sm" data-toggle="modal"
                                    data-target="#modal-ver-comentarios"
                                    wire:click="abrirModalVerComentarios({{ $item->id_menor_item }})" />

                                <x-adminlte-button label="Actualizar" icon="fas fa-edit" class="dropdown-item btn-sm"
                                    data-toggle="modal" data-target="#modal-actualizar"
                                    wire:click="abrirModalEdit({{ $item->id_menor_item }})" />
                            </x-tabla-dropdown>

                        </th>
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

        {{-- EQUIPOS FORESTALES --}}
        <div class="col-md-6">
            <x-table.tabla titulo="Equipos Forestales" paginado="paginadoForestales">

                <x-slot name="encabezados">
                    <th>#</th>
                    <th>Item</th>
                    <th>Cant. Operativos</th>
                    <th>Cant. Inoperativos</th>
                    <th>Compañia</th>
                    <th>Acciones</th>
                </x-slot>

                @forelse ($forestales as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <th>{{ $item->componente->nombre ?? 'S/D' }}</th>
                        <th>{{ $item->cantidad_operativo ?? 'S/D' }}</th>
                        <th>{{ $item->cantidad_inoperativo ?? 'S/D' }}</th>
                        <th>{{ $item->compania->compania ?? 'S/D' }}</th>
                        <th>
                            <x-tabla-dropdown>
                                <x-adminlte-button label="Ver Movimientos" icon="fas fa-eye"
                                    class="dropdown-item btn-sm" data-toggle="modal"
                                    data-target="#modal-ver-comentarios"
                                    wire:click="abrirModalVerComentarios({{ $item->id_menor_item }})" />

                                <x-adminlte-button label="Actualizar" icon="fas fa-edit" class="dropdown-item btn-sm"
                                    data-toggle="modal" data-target="#modal-actualizar"
                                    wire:click="abrirModalEdit({{ $item->id_menor_item }})" />
                            </x-tabla-dropdown>

                        </th>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                        </td>
                    </tr>
                @endforelse

                <x-slot name="paginacion">
                    {{ $forestales->links() }}
                </x-slot>

            </x-table.tabla>
        </div>
    </div>
</div>
