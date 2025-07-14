<div>
    @if ($mostrarFormAgregarApoyo)
        <livewire:cca.despacho.comentario-agregar servicio="{{ $servicio }}" lazy />
    @endif

    {{-- Tabla de apoyos del servicio existente --}}
    <x-table.table titulo="Apoyo" ocultarBuscador personalizarPaginacion="paginadoApoyos">

        <x-slot name="headerBotones">
            <x-adminlte-button class="btn-sm" type="button"
                label="{{ $mostrarFormAgregarApoyo ? 'Cancelar' : 'Agregar Apoyo' }}"
                icon="fas fa-{{ $mostrarFormAgregarApoyo ? 'minus' : 'plus' }}" theme="outline-success"
                wire:click="$toggle('mostrarFormAgregarApoyo')" />
        </x-slot>

        <x-slot name="cabeceras">
            <th>Compañia:</th>
            <th>Móvil:</th>
            <th>A Cargo:</th>
            <th>chofer:</th>
            <th>Tripulantes:</th>
            <th>Despacho Cia:</th>
            <th>Salida de Móvil:</th>
            <th>Llegada de Móvil:</th>
            <th>Móvil en base:</th>
        </x-slot>
        @forelse ($apoyos as $apoyo)
            <tr>
                <td>{{ $apoyo->compania ?? 'N/A' }}</td>
                <td>{{ $apoyo->tipo ?? 'N/A' }}-{{ $apoyo->movil ?? 'N/A' }}</td>
                <td>{{ $apoyo->nombrecompleto ?? 'N/A' }}</td>
                <td>{{ $apoyo->chofer ?? 'N/A' }}</td>
                <td>{{ $apoyo->cantidad_tripulantes ?? 'N/A' }}</td>

                <td>
                    @if ($apoyo->fecha_cia == null)
                        <button class="btn btn-primary" wire:click="horaAccion(1)">Accionar</button>
                    @else
                        {{ $apoyo->fecha_cia->format('d/m/Y H:i:s') }} Hs.
                    @endif
                </td>

                <td>
                    @if ($apoyo->fecha_movil == null)
                        <button class="btn btn-primary" wire:click="horaAccion(2)">Accionar</button>
                    @else
                        {{ $apoyo->fecha_movil->format('d/m/Y H:i:s') }} Hs.
                    @endif
                </td>

                <td>
                    @if ($apoyo->fecha_servicio == null)
                        <button class="btn btn-primary" wire:click="horaAccion(3)">Accionar</button>
                    @else
                        {{ $apoyo->fecha_servicio->format('d/m/Y H:i:s') }} Hs.
                    @endif
                </td>

                <td>
                    @if ($apoyo->fecha_base == null)
                        <button class="btn btn-primary" wire:click="horaAccion(4)">Accionar</button>
                    @else
                        {{ $apoyo->fecha_base->format('d/m/Y H:i:s') }} Hs.
                    @endif
                </td>
            </tr>
        @empty
            <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
        @endforelse
        <x-slot name="paginacion">
            {{ $apoyos->links() }}
        </x-slot>
    </x-table.table>
</div>
