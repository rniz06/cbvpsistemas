<div>
    {{-- Filtros de Búsqueda --}}
    <x-card.card-filtro>
        <div class="row">
            <div class="col-md-3">
                <x-select.select campo="departamento_id" label="Departamentos">
                    <option value="">Todos</option>
                    @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->iddepartamentos }}">
                            {{ $departamento->departamento ?? 'N/A' }}</option>
                    @endforeach
                </x-select.select>
            </div>

            <div class="col-md-3">
                <x-select.select campo="ciudad_id" label="Ciudades">
                    <option value="">Todos</option>
                    @foreach ($ciudades as $ciudad)
                        <option value="{{ $ciudad->idciudades }}">
                            {{ $ciudad->ciudad ?? 'N/A' }}</option>
                    @endforeach
                </x-select.select>
            </div>

            <div class="col-md-3">
                <x-select.select campo="compania_id" label="Compañias">
                    <option value="">Todos</option>
                    @foreach ($companias as $compania)
                        <option value="{{ $compania->idcompanias }}">
                            {{ $compania->compania ?? 'N/A' }}</option>
                    @endforeach
                </x-select.select>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="mr-2">Ver Compañia:</label>
                    @if ($compania_id !== '')
                        <button class="form-control btn-success text-center" wire:click="verCompania">Ver
                            Compañia</button>
                    @else
                        <button class="form-control btn-default text-center" disabled>Ver
                            Compañia</button>
                    @endif

                </div>
            </div>

        </div>
    </x-card.card-filtro>

    {{-- Tabla de Equipos Hidraulicos --}}

    <div class="col-md-12 row">
        {{-- Operativos --}}
        <div class="col-md-6">
            <x-table.table titulo="Operativos" personalizarBuscador="buscadorOperativo"
                personalizarPaginacion="paginadoOperativo">

                <x-slot name="headerBotones">
                    @can('Equipos Hidraulicos Exportar Excel')
                        <x-button.button click="excelOperativo" color="btn-block btn-outline-success btn-sm"
                            icon="fas fa-file-excel" class="ml-2 btn-sm float-right">
                            Excel
                        </x-button.button>
                    @endcan

                    @can('Equipos Hidraulicos Exportar Pdf')
                        <x-button.button click="pdfOperativo" color="btn-block btn-outline-secondary btn-sm"
                            icon="fas fa-file-pdf" class="ml-2 btn-sm float-right">
                            Pdf
                        </x-button.button>
                    @endcan
                </x-slot>

                <x-slot name="cabeceras">
                    <th>Marca:</th>
                    <th>Modelo:</th>
                    <th>Compañia:</th>
                </x-slot>

                @foreach ($operativos as $operativo)
                    <tr>
                        <td>{{ $operativo->marca ?? 'N/A' }}</td>
                        <td>{{ $operativo->modelo ?? 'N/A' }}</td>
                        <td>{{ $operativo->compania ?? 'N/A' }}</td>
                        @can('Equipos Hidraulicos Ver')
                            <td><a href="{{ route('materiales.hidraulicos.show', $operativo->id_hidraulico) }}"
                                    class="btn btn-block btn-sm btn-success">Ver Ficha</a></td>
                        @endcan
                    </tr>
                @endforeach
                <x-slot name="paginacion">
                    {{ $operativos->links() }}
                </x-slot>
            </x-table.table>
        </div>

        {{-- Inoperativos --}}
        <div class="col-md-6">
            <x-table.table titulo="Inoperativos" personalizarBuscador="buscadorInoperativo"
                personalizarPaginacion="paginadoInoperativo">

                <x-slot name="headerBotones">
                    @can('Equipos Hidraulicos Exportar Excel')
                        <x-button.button click="excelInoperativo" color="btn-block btn-outline-success btn-sm"
                            icon="fas fa-file-excel" class="ml-2 btn-sm float-right">
                            Excel
                        </x-button.button>
                    @endcan

                    @can('Equipos Hidraulicos Exportar Pdf')
                        <x-button.button click="pdfInoperativo" color="btn-block btn-outline-secondary btn-sm"
                            icon="fas fa-file-pdf" class="ml-2 btn-sm float-right">
                            Pdf
                        </x-button.button>
                    @endcan
                </x-slot>

                <x-slot name="cabeceras">
                    <th>Marca:</th>
                    <th>Modelo:</th>
                    <th>Compañia:</th>
                </x-slot>

                @foreach ($inoperativos as $inoperativo)
                    <tr>
                        <td>{{ $inoperativo->marca ?? 'N/A' }}</td>
                        <td>{{ $inoperativo->modelo ?? 'N/A' }}</td>
                        <td>{{ $inoperativo->compania ?? 'N/A' }}</td>
                        @can('Equipos Hidraulicos Ver')
                            <td><a href="{{ route('materiales.hidraulicos.show', $operativo->id_hidraulico) }}"
                                    class="btn btn-block btn-sm btn-danger">Ver Ficha</a></td>
                        @endcan
                    </tr>
                @endforeach
                <x-slot name="paginacion">
                    {{ $inoperativos->links() }}
                </x-slot>
            </x-table.table>
        </div>
    </div>
</div>
