<div class="row">
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

    {{-- Servicios --}}
    <div class="col-md-{{ $servicio_id !== null ? 6 : 12 }}">
        <x-table.table titulo="Servicios como primera respuesta" ocultarBuscador
            personalizarPaginacion="paginadoServicios">

            <x-slot name="headerBotones">
                <x-adminlte-button class="btn-sm" label="Excel" theme="outline-success" icon="fas fa-file-excel"
                    wire:click="excelServicios" />
                <x-adminlte-button class="btn-sm" label="Pdf" theme="outline-secondary" icon="fas fa-file-pdf"
                    wire:click="pdfServicios" />
            </x-slot>

            <x-slot name="cabeceras">
                <th>Servicio:</th>
                <th>Conteo:</th>
            </x-slot>

            @forelse ($serviciosTabla as $servicioTabla)
                <tr>
                    <td>{{ $servicioTabla->servicio ?? 'N/A' }}</td>
                    <td>{{ $servicioTabla->conteo ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
                </tr>
            @endforelse
            <x-slot name="paginacion">
                {{ $serviciosTabla->links() }}
            </x-slot>
        </x-table.table>
    </div>

    {{-- Clasificaciones --}}
    @if ($servicio_id !== null)
        <div class="col-md-6">
            <x-table.table titulo="Clasificaciones" ocultarBuscador personalizarPaginacion="paginadoClasificaciones">

                <x-slot name="headerBotones">
                    <x-adminlte-button class="btn-sm" label="Excel" theme="outline-success" icon="fas fa-file-excel"
                        wire:click="excelClasificaciones" />
                    <x-adminlte-button class="btn-sm" label="Pdf" theme="outline-secondary" icon="fas fa-file-pdf"
                        wire:click="pdfClasificaciones" />
                </x-slot>

                <x-slot name="cabeceras">
                    <th>Clasificación:</th>
                    <th>Conteo:</th>
                </x-slot>
                @forelse ($clasificacionesTabla as $clasificacionTabla)
                    <tr>
                        <td>{{ $clasificacionTabla->clasificacion ?? 'N/A' }}</td>
                        <td>{{ $clasificacionTabla->conteo ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
                    </tr>
                @endforelse
                <x-slot name="paginacion">
                    {{ $clasificacionesTabla->links() }}
                </x-slot>
            </x-table.table>
        </div>

    @endif

    @if ($compania_id !== null)
        {{-- Servicios Apoyos --}}
        <div class="col-md-{{ $servicio_id !== null ? 6 : 12 }}">
            <x-table.table titulo="Cantidad de despachos para apoyo" ocultarBuscador
                personalizarPaginacion="paginadoServiciosApoyos">

                <x-slot name="headerBotones">
                    <x-adminlte-button class="btn-sm" label="Excel" theme="outline-success" icon="fas fa-file-excel"
                        wire:click="excelServicios" />
                    <x-adminlte-button class="btn-sm" label="Pdf" theme="outline-secondary" icon="fas fa-file-pdf"
                        wire:click="pdfServicios" />
                </x-slot>

                <x-slot name="cabeceras">
                    <th>Servicio:</th>
                    <th>Conteo:</th>
                </x-slot>

                @forelse ($serviciosApoyosTabla as $servicioTabla)
                    <tr>
                        <td>{{ $servicioTabla->servicio ?? 'N/A' }}</td>
                        <td>{{ $servicioTabla->conteo ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
                    </tr>
                @endforelse
                <x-slot name="paginacion">
                    {{ $serviciosApoyosTabla->links() }}
                </x-slot>
            </x-table.table>
        </div>
    @endif

    {{-- Clasificaciones --}}
    @if ($servicio_id !== null and $compania_id !== null)
        <div class="col-md-6">
            <x-table.table titulo="Clasificaciones" ocultarBuscador personalizarPaginacion="paginadoClasificaciones">

                <x-slot name="headerBotones">
                    <x-adminlte-button class="btn-sm" label="Excel" theme="outline-success" icon="fas fa-file-excel"
                        wire:click="excelClasificaciones" />
                    <x-adminlte-button class="btn-sm" label="Pdf" theme="outline-secondary" icon="fas fa-file-pdf"
                        wire:click="pdfClasificaciones" />
                </x-slot>

                <x-slot name="cabeceras">
                    <th>Clasificación:</th>
                    <th>Conteo:</th>
                </x-slot>
                @forelse ($clasificacionesApoyosTabla as $clasificacionTabla)
                    <tr>
                        <td>{{ $clasificacionTabla->clasificacion ?? 'N/A' }}</td>
                        <td>{{ $clasificacionTabla->conteo ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
                    </tr>
                @endforelse
                <x-slot name="paginacion">
                    {{ $clasificacionesApoyosTabla->links() }}
                </x-slot>
            </x-table.table>
        </div>

    @endif
</div>
