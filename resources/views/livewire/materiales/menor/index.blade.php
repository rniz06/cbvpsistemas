<div>
    {{-- FILTROS DE BUSQUEDA --}}
    <x-adminlte-card theme="light" title="Filtros de Búsqueda" icon="fas fa-filter" header-class="text-muted text-sm"
        collapsible>

        <div class="col-md-12 row">

            {{-- ITEMS --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Items:</div>
                        </div>
                        <select class="form-control @error('buscarComponenteId') is-invalid @enderror"
                            id="buscarComponenteId" name="buscarComponenteId"
                            wire:model.live.debounce.200ms="buscarComponenteId">
                            <option value="">Todos</option>
                            @foreach ($componentes as $componente)
                                <option value="{{ $componente->id_menor_componente }}">
                                    {{ $componente->nombre ?? 'S/D' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- CATEGORIAS --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Categorias:</div>
                        </div>
                        <select class="form-control @error('buscarCategoriaId') is-invalid @enderror"
                            id="buscarCategoriaId" name="buscarCategoriaId"
                            wire:model.live.debounce.200ms="buscarCategoriaId">
                            <option value="">Todos</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id_menor_categoria }}">
                                    {{ $categoria->nombre ?? 'S/D' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- COMPANIAS --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Compañias:</div>
                        </div>
                        <select class="form-control @error('buscarCompaniaId') is-invalid @enderror"
                            id="buscarCompaniaId" name="buscarCompaniaId"
                            wire:model.live.debounce.200ms="buscarCompaniaId">
                            <option value="">Todos</option>
                            @foreach ($companias as $compania)
                                <option value="{{ $compania->id_compania }}">
                                    {{ $compania->compania ?? 'S/D' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <x-adminlte-button label="Ver Compañia" theme="outline-success" class="w-100" :disabled="!$buscarCompaniaId"
                    onclick="window.location='{{ $buscarCompaniaId ? route('materiales.menor.ver-compania', $buscarCompaniaId) : '#' }}'" />
            </div>

        </div>
    </x-adminlte-card>

    {{-- MODAL COMPONENTE DE ACTUALIZACION --}}
    <x-adminlte-modal id="modal-actualizar" title="Actualizar Registro" theme="light" icon="fas fa-edit" v-centered
        static-backdrop size="lg">
        @if ($item)
            @livewire('materiales.menor.edit', ['item' => $item], key('modal-edit' . $item))
        @endif
        <x-slot name="footerSlot"></x-slot>
    </x-adminlte-modal>

    {{-- MODAL COMPONENTE VER COMENTARIOS --}}
    <x-adminlte-modal id="modal-ver-comentarios" title="Historial de Movimientos" theme="light" icon="fas fa-list-ul"
        v-centered static-backdrop size="xl">
        @if ($item)
            @livewire('materiales.menor.ver-comentarios', ['item' => $item], key('modal-ver-comentarios' . $item))
        @endif
        <x-slot name="footerSlot"></x-slot>
    </x-adminlte-modal>

        <div class="col-md-12">
            <x-table.tabla titulo="Material Menor" >

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
                        <td>{{ $loop->iteration + $menor->firstItem() - 1 }}</td>
                        <td>{{ $item->componente->nombre ?? 'S/D' }}</td>
                        <td>{{ $item->componente->categoria->nombre ?? 'S/D' }}</td>
                        <td>{{ $item->cantidad_operativo ?? 'S/D' }}</td>
                        <td>{{ $item->cantidad_inoperativo ?? 'S/D' }}</td>
                        <td>{{ $item->compania->compania ?? 'S/D' }}</td>
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
                    {{ $menor->links() }}
                </x-slot>

            </x-table.tabla>
        </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/slimselect.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/slimselect.js') }}"></script>

    <script>
        new SlimSelect({
            select: '#buscarComponenteId'
        })

        new SlimSelect({
            select: '#buscarCategoriaId'
        })

        new SlimSelect({
            select: '#buscarCompaniaId'
        })
    </script>
@endpush
