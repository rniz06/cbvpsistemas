<div>
    {{-- Tabla de Móviles en servicio --}}
    <div wire:poll.10s>
        <x-table.table titulo="Listado de Apoyos Activos" ocultarBuscador>
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
</div>
