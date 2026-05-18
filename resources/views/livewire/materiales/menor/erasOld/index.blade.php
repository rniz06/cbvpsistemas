<div>
    {{-- FILTROS DE BUSQUEDA --}}
    <x-adminlte-card theme="light" title="Filtros de Búsqueda" icon="fas fa-filter" header-class="text-muted text-sm"
        collapsible>

        <div class="col-md-12 row">

            {{-- MARCAS --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Marcas:</div>
                        </div>
                        <select class="form-control @error('buscarMarcaId') is-invalid @enderror"
                            id="buscarMarcaId" name="buscarMarcaId"
                            wire:model.live.debounce.200ms="buscarMarcaId">
                            <option value="">Todos</option>
                            @foreach ($marcas as $id => $nombre)
                                <option value="{{ $id }}">
                                    {{ $nombre ?? 'S/D' }}</option>
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
                            @foreach ($companias as $id => $compania)
                                <option value="{{ $id }}">
                                    {{ $compania ?? 'S/D' }}</option>
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

    <div class="col-md-12">
        <x-table.tabla titulo="Eras" paginado="paginado">

            <x-slot name="encabezados">
                <th>#</th>
                <th>Marca</th>
                <th>Cant. Operativos</th>
                <th>Cant. Inoperativos</th>
                <th>Cant. Total</th>
                <th>Compañia</th>
                <th>Acciones</th>
            </x-slot>

            @forelse ($eras as $era)
                <tr>
                    <td>{{ $loop->iteration + $eras->firstItem() - 1 }}</td>
                    <td>{{ $era->marca->nombre ?? 'S/D' }}</td>
                    <td><span class="badge badge-success">{{ $era->cantidad_operativo ?? 'S/D' }}</span></td>
                    <td><span class="badge badge-danger">{{ $era->cantidad_inoperativo ?? 'S/D' }}</span></td>
                    <td><span class="badge badge-secondary">{{ $era->cantidad_total ?? 'S/D' }}</span></td>
                    <td>{{ $era->compania->compania ?? 'S/D' }}</td>
                    <td>
                        {{-- <x-tabla-dropdown>
                            @can('Material Menor Ver')
                                <x-adminlte-button label="Ver Movimientos" icon="fas fa-eye" class="dropdown-item btn-sm"
                                    data-toggle="modal" data-target="#modal-ver-comentarios"
                                    wire:click="abrirModalVerComentarios({{ $item->id_menor_item }})" />
                            @endcan

                            @can('Material Menor Editar')
                                <x-adminlte-button label="Actualizar" icon="fas fa-edit" class="dropdown-item btn-sm"
                                    data-toggle="modal" data-target="#modal-actualizar"
                                    wire:click="abrirModalEdit({{ $item->id_menor_item }})" />
                            @endcan
                        </x-tabla-dropdown> --}}
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/slimselect.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/slimselect.js') }}"></script>

    <script>
        new SlimSelect({
            select: '#buscarMarcaId'
        })

        new SlimSelect({
            select: '#buscarCompaniaId'
        })
    </script>
@endpush