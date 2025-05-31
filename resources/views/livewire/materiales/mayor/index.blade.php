<div>
    {{-- Filtros de Búsqueda --}}
    <x-card.card-filtro>
        <div class="row">
            <div class="col-md-4">
                <x-select.select campo="departamento_id" label="Departamentos">
                    <option value="">Todos</option>
                    @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->iddepartamentos }}">
                            {{ $departamento->departamento ?? 'N/A' }}</option>
                    @endforeach
                </x-select.select>
            </div>

            <div class="col-md-4">
                <x-select.select campo="ciudad_id" label="Ciudades">
                    <option value="">Todos</option>
                    @foreach ($ciudades as $ciudad)
                        <option value="{{ $ciudad->idciudades }}">
                            {{ $ciudad->ciudad ?? 'N/A' }}</option>
                    @endforeach
                </x-select.select>
            </div>

            <div class="col-md-4">
                <x-select.select campo="compania_id" label="Compañias">
                    <option value="">Todos</option>
                    @foreach ($companias as $compania)
                        <option value="{{ $compania->idcompanias }}">
                            {{ $compania->compania ?? 'N/A' }}</option>
                    @endforeach
                </x-select.select>
            </div>

        </div>
    </x-card.card-filtro>

    {{-- Tabla de Materiales --}}
    <div class="col-md-12 row">

        {{-- Operativos --}}
        <div class="col-md-6">


            <x-tabla titulo="Operativos">

                <x-slot name="headerBotones">
                    <x-button.button click="excelOperativo" color="btn-block btn-outline-success btn-sm"
                        icon="fas fa-file-excel" class="ml-2 btn-sm float-right" title="Exportar a Excel">
                        Excel
                    </x-button.button>

                    <x-button.button click="pdfOperativo" color="btn-block btn-outline-secondary btn-sm"
                        icon="fas fa-file-pdf" class="ml-2 btn-sm float-right" title="Exportar a Excel">
                        Pdf
                    </x-button.button>
                </x-slot>

                <x-slot name="cabeceras">
                    <th>Móvil:</th>
                    <th>Compañia:</th>
                    <th>Ficha:</th>
                </x-slot>

                @foreach ($operativos as $operativo)
                    <tr>
                        <td>{{ $operativo->tipo ?? 'N/A' }}-{{ $operativo->movil ?? 'N/A' }}</td>
                        <td>{{ $operativo->compania ?? 'N/A' }}</td>
                        <td><a href="{{ route('materiales.mayor.show', $operativo->id_movil) }}"
                                class="btn btn-block btn-sm btn-success">Ver Ficha</a></td>
                    </tr>
                @endforeach
                <x-slot name="paginacion">
                    {{ $operativos->links() }}
                </x-slot>
            </x-tabla>
        </div>

        {{-- Inoperativos --}}
        <div class="col-md-6">
            <x-tabla titulo="Inoperativos">

                <x-slot name="headerBotones">
                    <x-button.button click="excelInoperativo" color="btn-block btn-outline-success btn-sm"
                        icon="fas fa-file-excel" class="ml-2 btn-sm float-right">
                        Excel
                    </x-button.button>

                    <x-button.button click="pdfInoperativo" color="btn-block btn-outline-secondary btn-sm"
                        icon="fas fa-file-pdf" class="ml-2 btn-sm float-right">
                        Pdf
                    </x-button.button>
                </x-slot>

                <x-slot name="cabeceras">
                    <th>Móvil:</th>
                    <th>Compañia:</th>
                    <th>Ficha:</th>
                </x-slot>

                @foreach ($inoperativos as $inoperativo)
                    <tr>
                        <td>{{ $inoperativo->tipo ?? 'N/A' }}-{{ $inoperativo->movil ?? 'N/A' }}</td>
                        <td>{{ $inoperativo->compania ?? 'N/A' }}</td>
                        <td><a href="{{ route('materiales.mayor.show', $inoperativo->id_movil) }}"
                                class="btn btn-block btn-sm btn-danger">Ver Ficha</a></td>
                    </tr>
                @endforeach
                <x-slot name="paginacion">
                    {{ $inoperativos->links() }}
                </x-slot>
            </x-tabla>
        </div>

        {{-- Resumen --}}
        <div class="col-md-12">
            <x-tabla titulo="Resumen">

                <x-slot name="headerBotones">
                    <x-button.button click="excelResumen" color="btn-block btn-outline-success btn-sm"
                        icon="fas fa-file-excel" class="ml-2 btn-sm float-right">
                        Excel
                    </x-button.button>

                    <x-button.button click="pdfResumen" color="btn-block btn-outline-secondary btn-sm"
                        icon="fas fa-file-pdf" class="ml-2 btn-sm float-right">
                        Pdf
                    </x-button.button>
                </x-slot>

                <x-slot name="cabeceras">
                    <th>Móvil:</th>
                    <th>Operativo:</th>
                    <th>Inoperativo:</th>
                </x-slot>

                @foreach ($resumen as $registro)
                    <tr>
                        <td>{{ $registro->tipo ?? 'N/A' }}</td>
                        <td><span class="badge badge-success">{{ $registro->operativos ?? 'N/A' }}</span></td>
                        <td><span class="badge badge-danger">{{ $registro->inoperativos ?? 'N/A' }}</span></td>
                    </tr>
                @endforeach
                <x-slot name="paginacion">
                    {{ $resumen->links() }}
                </x-slot>
            </x-tabla>
        </div>
        {{-- {{ $resumen }} --}}
    </div>
</div>
