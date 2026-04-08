<div>
    {{-- FILTROS DE BUSQUEDA --}}
    <x-adminlte-card theme="light" title="Filtros de Búsqueda" icon="fas fa-filter" header-class="text-muted text-sm"
        collapsible>

        <div class="col-md-12 row">
            {{-- COMPONENTE --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Items:</div>
                        </div>
                        <select class="form-control @error('buscarComponenteId') is-invalid @enderror"
                            id="buscarComponenteId" name="buscarComponenteId" wire:model.live.debounce.200ms="buscarComponenteId">
                            <option value="">Todos</option>
                            @foreach ($this->componentes as $componente)
                                <option value="{{ $componente->id_menor_componente }}">
                                    {{ $componente->nombre ?? 'S/D' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- MARCA --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Marcas:</div>
                        </div>
                        <select class="form-control @error('buscarMarcaId') is-invalid @enderror" id="buscarMarcaId"
                            name="buscarMarcaId" wire:model.live.debounce.200ms="buscarMarcaId">
                            <option value="">Todos</option>
                            @foreach ($this->marcas as $marca)
                                <option value="{{ $marca->id_menor_marca }}">
                                    {{ $marca->nombre ?? 'S/D' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- COMPAÑIA --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Compañias:</div>
                        </div>
                        <select class="form-control @error('buscarCompaniaId') is-invalid @enderror"
                            id="buscarCompaniaId" name="buscarCompaniaId" wire:model.live.debounce.200ms="buscarCompaniaId">
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
        {{-- OPERATIVOS --}}
        <div class="col-md-6">
            <x-table.tabla titulo="Operativos" pdf="pdfOperativos" excel="excelOperativos"
                dropdown_direccion="dropleft">

                <x-slot name="encabezados">
                    {{-- NUMERO EN LA FILA --}}
                    <th style="width: 10px">N°</th>

                    {{-- NOMBRE --}}
                    <th>Nombre</th>

                    {{-- MARCA --}}
                    <th>Marca</th>

                    {{-- COMPAÑIA --}}
                    <th>Compañia</th>

                    <th></th>

                </x-slot>

                @forelse ($operativos as $index => $operativo)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $operativo->componente->nombre ?? 'S/D' }}</td>
                        <td>{{ $operativo->componente->marca->nombre ?? 'S/D' }}</td>
                        <td>{{ $operativo->compania->compania ?? 'S/D' }}</td>
                        <td><x-adminlte-button label="Ver" class="btn-sm" icon="fas fa-eye" /></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                        </td>
                    </tr>
                @endforelse

                <x-slot name="paginacion">
                    {{ $operativos->links() }}
                </x-slot>
            </x-table.tabla>
        </div>

        {{-- INOPERATIVOS --}}
        <div class="col-md-6">
            <x-table.tabla titulo="Inoperativos" pdf="pdfInoperativos" excel="excelInoperativos"
                dropdown_direccion="dropleft">

                <x-slot name="encabezados">
                    {{-- NUMERO EN LA FILA --}}
                    <th style="width: 10px">N°</th>

                    {{-- NOMBRE --}}
                    <th>Nombre</th>

                    {{-- MARCA --}}
                    <th>Marca</th>

                    {{-- COMPAÑIA --}}
                    <th>Compañia</th>

                    <th></th>

                </x-slot>

                @forelse ($inoperativos as $index => $inoperativo)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $inoperativo->componente->nombre ?? 'S/D' }}</td>
                        <td>{{ $inoperativo->componente->marca->nombre ?? 'S/D' }}</td>
                        <td>{{ $inoperativo->compania->compania ?? 'S/D' }}</td>
                        <td><x-adminlte-button label="Ver" class="btn-sm" icon="fas fa-eye" /></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                        </td>
                    </tr>
                @endforelse

                <x-slot name="paginacion">
                    {{ $inoperativos->links() }}
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
            select: '#buscarComponenteId'
        })

        new SlimSelect({
            select: '#buscarMarcaId'
        })

        new SlimSelect({
            select: '#buscarCompaniaId'
        })
    </script>
@endpush
