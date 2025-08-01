<div>

    {{-- Filtros de Búsqueda --}}
    <x-card.card-filtro>
        <div class="row">

            {{-- Fecha Desde --}}
            <x-adminlte-input name="fecha_desde" type="date" wire:model.live="fecha_desde" label="Desde:"
                fgroup-class="col-md-2" />

            {{-- Fecha Hasta --}}
            <x-adminlte-input name="fecha_hasta" type="date" wire:model.live="fecha_hasta" label="Hasta:"
                fgroup-class="col-md-2" />

            {{-- Companias --}}
            <div class="col-md-2">
                <x-adminlte-select name="compania_id" label="Compañias:" wire:model.live.debounce.250ms="compania_id">
                    <option value="">Todos</option>
                    @foreach ($companias as $compania)
                        <option value="{{ $compania->id_compania }}">
                            {{ $compania->compania ?? 'S/D' }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            {{-- Servicios --}}
            <div class="col-md-2">
                <x-adminlte-select name="servicio_id" label="Servicio:" wire:model.live.debounce.250ms="servicio_id">
                    <option value="">Todos</option>
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id_servicio }}">
                            {{ $servicio->servicio ?? 'S/D' }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            {{-- Clasificaciones --}}
            <div class="col-md-2">
                <x-adminlte-select name="clasificacion_id" label="Clasificación:"
                    wire:model.live.debounce.250ms="clasificacion_id">
                    <option value="">Todos</option>
                    @foreach ($clasificaciones as $clasificacion)
                        <option value="{{ $clasificacion->id_servicio_clasificacion }}">
                            {{ $clasificacion->clasificacion ?? 'S/D' }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

        </div>
    </x-card.card-filtro>

    {{-- Historico --}}
    <div class="col-md-12">
        <x-table.table titulo="Historico de Servicios" excel pdf ocultarBuscador>

            <x-slot name="cabeceras">
                <th>Compañia:</th>
                <th>Servicio:</th>
                <th>Clasificación:</th>
                <th>Móvil:</th>
                <th>A cargo:</th>
                <th>Chófer:</th>
                <th>Tripulantes:</th>
                <th>Fecha:</th>
                <th>Ver:</th>

            </x-slot>
            @forelse ($historicos as $historico)
                <tr>
                    <td>{{ $historico->compania ?? 'N/A' }}</td>
                    <td>{{ $historico->servicio ?? 'N/A' }}</td>
                    <td>{{ $historico->clasificacion ?? 'N/A' }}</td>
                    <td>{{ $historico->tipo ?? 'N/A' }}-{{ $historico->movil ?? 'N/A' }}</td>

                    <td>
                        @if (is_null($historico->acargo))
                            {{-- Mostrar acargo_aux --}}
                            {{ $historico->acargo_aux ?? 'S/D' }}
                        @else
                            {{ $historico->acargo_codigo_comisionamiento ?? ($historico->acargo_codigo ?? 'S/D') }} -
                            {{ $historico->acargo_nombrecompleto ?? 'S/D' }}
                        @endif

                    </td>
                    {{-- <td>
                        @if (is_null($historico->acargo))
                            {{ $historico->codigo_comisionamiento ?? 'S/D' }}
                        @else
                            @php
                                $letraCategoria = $historico->acargo_categoria
                                    ? substr($historico->acargo_categoria, 0, 1)
                                    : 'N/A';
                                $codigo = $historico->acargo_codigo ?? 'N/A';
                            @endphp
                            {{ "$letraCategoria-$codigo" }}
                        @endif

                    </td> --}}
                    <td>
                        @if ($historico->chofer === null)
                            <span class="badge badge-secondary">Rentado</span>
                        @else
                            @php
                                $letraCategoria = $historico->chofer_categoria
                                    ? substr($historico->chofer_categoria, 0, 1)
                                    : 'N/A';
                                $codigo = $historico->chofer_codigo ?? 'N/A';
                            @endphp
                            {{ "$letraCategoria-$codigo" }}
                        @endif
                    </td>
                    <td>{{ $historico->cantidad_tripulantes ?? 'N/A' }}</td>
                    <td>{{ $historico->fecha_alfa->format('d/m/Y H:i:s') . ' Hs.' ?? 'N/A' }}</td>
                    <td><a href="{{ route('cca.despacho.ver-servicio', $historico->id_servicio_existente) }}"
                            class="btn btn-block btn-sm btn-success">Ver Servicio</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
                </tr>
            @endforelse
            <x-slot name="paginacion">
                {{ $historicos->links() }}
            </x-slot>
        </x-table.table>
    </div>
</div>
