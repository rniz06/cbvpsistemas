<div>

    {{-- Tabla de Móviles en servicio --}}
    <div wire:poll.10s>
        <x-table.table titulo="Móviles en servicio" ocultarBuscador personalizarPaginacion="paginadolistadoActivos">
            <x-slot name="cabeceras">
                <th>Compañía:</th>
                <th>Servicio:</th>
                <th>Clasificación:</th>
                <th>Móvil:</th>
                <th>Información:</th>
                <th>Fecha Y Hora:</th>
                <th>Ver:</th>
            </x-slot>

            {{-- Spinner centrado en toda la tabla mientras se actualiza --}}
            <div wire:loading class="loading-overlay">
                <div class="spinner-container">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                    <div class="mt-2">Actualizando datos...</div>
                </div>
            </div>

            {{-- Filas de datos ocultas mientras wire:poll está activo --}}
            <tbody wire:loading.remove>
                @forelse ($listadoActivos as $listadoActivo)
                    <tr>
                        <td>{{ $listadoActivo->compania ?? 'N/A' }}</td>
                        <td>{{ $listadoActivo->servicio ?? 'N/A' }}</td>
                        <td>{{ $listadoActivo->clasificacion ?? 'N/A' }}</td>
                        <td>{{ $listadoActivo->tipo ?? 'N/A' }}-{{ $listadoActivo->movil ?? 'N/A' }}</td>
                        <td>{{ $listadoActivo->informacion_servicio ?? 'N/A' }}</td>
                        <td>{{ $listadoActivo->fecha_alfa->format('d/m/Y H:i:s') ?? 'N/A' }}</td>
                        <td>
                            <a class="btn btn-success btn-sm"
                                href="{{ route('cca.despacho.ver-servicio', $listadoActivo->id_servicio_existente) }}"><i
                                    class="fas fa-eye"></i>Ver Servicio</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
                    </tr>
                @endforelse
            </tbody>

            <x-slot name="paginacion">
                {{ $listadoActivos->links() }}
            </x-slot>
        </x-table.table>
    </div>

    {{-- Tabla de Móviles en servicio --}}
    <div wire:poll.10s>
        <x-table.table titulo="Listado de Apoyos Activos" ocultarBuscador personalizarPaginacion="paginadoApoyosActivos">
            <x-slot name="cabeceras">
                <th>Compañía:</th>
                <th>Servicio:</th>
                <th>Clasificación:</th>
                <th>Móvil:</th>
                <th>Fecha Y Hora:</th>
                <th>Ver:</th>
            </x-slot>

            {{-- Spinner centrado en toda la tabla mientras se actualiza --}}
            <div wire:loading class="loading-overlay">
                <div class="spinner-container">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                    <div class="mt-2">Actualizando datos...</div>
                </div>
            </div>

            {{-- Filas de datos ocultas mientras wire:poll está activo --}}
            <tbody wire:loading.remove>
                @forelse ($apoyosActivos as $apoyosActivo)
                    <tr>
                        <td>{{ $apoyosActivo->compania ?? 'N/A' }}</td>
                        <td>{{ $apoyosActivo->servicio ?? 'N/A' }}</td>
                        <td>{{ $apoyosActivo->clasificacion ?? 'N/A' }}</td>
                        <td>{{ $apoyosActivo->tipo ?? 'N/A' }}-{{ $apoyosActivo->movil ?? 'N/A' }}</td>
                        <td>{{ $apoyosActivo->fecha_cia->format('d/m/Y H:i:s') ?? 'N/A' }} Hs.</td>
                        <td>
                            <a class="btn btn-success btn-sm"
                                href="{{ route('cca.despacho.ver-servicio', $apoyosActivo->servicio_existente_id) }}"><i
                                    class="fas fa-eye"></i>Ver Servicio</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
                    </tr>
                @endforelse
            </tbody>

            <x-slot name="paginacion">
                {{ $apoyosActivos->links() }}
            </x-slot>
        </x-table.table>
    </div>


    {{-- Tabla de Sin despacho de compañias --}}
    <div wire:poll.10s class="position-relative">
        <x-table.table titulo="Sin despacho de compañias" ocultarBuscador
            personalizarPaginacion="paginadolistadoSinCompanias">

            <x-slot name="cabeceras">
                <th>Servicio:</th>
                <th>Clasificación:</th>
                <th>Información:</th>
                <th>Ver:</th>
            </x-slot>

            {{-- Animación de carga centrada --}}
            <div wire:loading class="loading-overlay">
                <div class="spinner-container">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                    <div class="mt-2">Actualizando datos...</div>
                </div>
            </div>

            {{-- Filas de datos --}}
            <tbody wire:loading.remove>
                @forelse ($listadoSinCompanias as $listadoSinCompania)
                    <tr>
                        <td>{{ $listadoSinCompania->servicio ?? 'N/A' }}</td>
                        <td>{{ $listadoSinCompania->clasificacion ?? 'N/A' }}</td>
                        <td>{{ $listadoSinCompania->informacion_servicio ?? 'N/A' }}</td>
                        <td>
                            <a class="btn btn-success btn-sm"
                                href="{{ route('cca.despacho.despacho-por-servicio-add-compania', $listadoSinCompania->id_servicio_existente) }}"><i
                                    class="fas fa-eye"></i>Ver Servicio</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
                    </tr>
                @endforelse
            </tbody>

            <x-slot name="paginacion">
                {{ $listadoSinCompanias->links() }}
            </x-slot>
        </x-table.table>
    </div>


    {{-- Tabla de Sin despacho de móviles --}}
    <div wire:poll.10s class="position-relative">
        <x-table.table titulo="Sin despacho de móviles" ocultarBuscador
            personalizarPaginacion="paginadolistadoSinMoviles">

            <x-slot name="cabeceras">
                <th>Compañía:</th>
                <th>Servicio:</th>
                <th>Clasificación:</th>
                <th>Información:</th>
                <th>Ver:</th>
            </x-slot>

            {{-- Animación de carga centrada --}}
            <div wire:loading class="loading-overlay">
                <div class="spinner-container">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                    <div class="mt-2">Actualizando datos...</div>
                </div>
            </div>

            {{-- Filas de datos --}}
            <tbody wire:loading.remove>
                @forelse ($listadoSinMoviles as $listadoSinMovil)
                    <tr>
                        <td>{{ $listadoSinMovil->compania ?? 'N/A' }}</td>
                        <td>{{ $listadoSinMovil->servicio ?? 'N/A' }}</td>
                        <td>{{ $listadoSinMovil->clasificacion ?? 'N/A' }}</td>
                        <td>{{ $listadoSinMovil->informacion_servicio ?? 'N/A' }}</td>
                        <td>
                            <a class="btn btn-success btn-sm"
                                href="{{ route('cca.despacho.despacho-por-servicio-final', $listadoSinMovil->id_servicio_existente) }}"><i
                                    class="fas fa-eye"></i>Ver Servicio</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
                    </tr>
                @endforelse
            </tbody>

            <x-slot name="paginacion">
                {{ $listadoSinMoviles->links() }}
            </x-slot>
        </x-table.table>
    </div>

</div>


@push('css')
    <style>
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.75);
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner-container {
            text-align: center;
        }
    </style>
@endpush
