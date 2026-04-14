<div>
    {{-- FILTROS DE BUSQUEDA --}}
    <x-adminlte-card theme="light" title="Filtros de Búsqueda" icon="fas fa-filter" header-class="text-muted text-sm"
        collapsible>

        <div class="col-md-12 row">

            {{-- COMPAÑIA --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Compañias:</div>
                        </div>
                        <select class="form-control @error('buscarIdCompania') is-invalid @enderror"
                            id="buscarIdCompania" name="buscarIdCompania"
                            wire:model.live.debounce.200ms="buscarIdCompania">
                            <option value="">Todos</option>
                            @foreach ($this->companias as $compania)
                                <option value="{{ $compania->id_compania }}">
                                    {{ $compania->compania ?? 'S/D' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </x-adminlte-card>

    <div class="row">
        {{-- COMPANIAS --}}
        <div class="col-md-12">
            <x-table.tabla titulo="Listado de Compañias" dropdown_direccion="dropleft">

                <x-slot name="encabezados">
                    {{-- NUMERO EN LA FILA --}}
                    <th style="width: 10px">N°</th>

                    {{-- COMPAÑIA --}}
                    <th>Compañia</th>

                    @can('Material Menor Ver')
                        <th></th>
                    @endcan

                </x-slot>

                @forelse ($companias as $compania)
                    <tr>
                        <td>{{ $loop->iteration + $companias->firstItem() - 1 }}</td>
                        <td>{{ $compania->compania ?? 'S/D' }}</td>
                        @can('Material Menor Ver Compania')
                            <td><a href="{{ route('materiales.menor.ver-compania', $compania->id_compania) }}"
                                    class="btn btn-sm btn-outline-success w-100"><i class="fas fa-eye mr-1"></i> Ver
                                    Ficha de Cia</a></td>
                        @endcan
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                        </td>
                    </tr>
                @endforelse

                <x-slot name="paginacion">
                    {{ $companias->links() }}
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
        new SlimSelect({
            select: '#buscarIdCompania'
        })
    </script>
@endpush
