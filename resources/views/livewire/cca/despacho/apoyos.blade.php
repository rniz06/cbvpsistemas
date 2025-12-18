<div>
    @if ($mostrarFormAgregarDetalle)
        <livewire:cca.despacho.apoyo-agregar-detalle apoyo="{{ $apoyo_seleccionado_id }}" lazy />
    @endif

    @if ($mostrarFormAgregarApoyo)
        <livewire:cca.despacho.apoyo-agregar servicio="{{ $servicio }}" lazy />
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
            <th>911:</th>
            <th>Despacho Cia:</th>
            <th>Salida de Móvil:</th>
            <th>Llegada de Móvil:</th>
            <th>Móvil en base:</th>
            <th>Km Final:</th>
        </x-slot>
        @forelse ($apoyos as $apoyo)
            <tr>
                <td>{{ $apoyo->compania ?? 'N/A' }}</td>
                <td>{{ $apoyo->tipo ?? 'N/A' }}-{{ $apoyo->movil ?? 'N/A' }}</td>
                <td>{{ $apoyo->acargo ?? 'S/D' }}</td>
                <td>{{ $apoyo->chofer ?? 'S/D' }}</td>
                <td>{{ $apoyo->cantidad_tripulantes ?? 'N/A' }}</td>
                <td>{{ $apoyo->despacho_policia ? 'SI' : 'NO' }}</td>

                <td>
                    @if ($apoyo->fecha_cia == null)
                        <button class="btn btn-primary" wire:click="horaAccion(1, {{ $apoyo->idservicio_existente_apoyo }})">Accionar</button>
                    @else
                        {{ $apoyo->fecha_cia->format('d/m/Y H:i:s') }} Hs.
                    @endif
                </td>

                <td>
                    @if ($apoyo->fecha_movil == null)
                        <button class="btn btn-primary" wire:click="horaAccion(2, {{ $apoyo->idservicio_existente_apoyo }})">Accionar</button>
                    @else
                        {{ $apoyo->fecha_movil->format('d/m/Y H:i:s') }} Hs.
                    @endif
                </td>

                <td>
                    @if ($apoyo->fecha_servicio == null)
                        <button class="btn btn-primary" wire:click="horaAccion(3, {{ $apoyo->idservicio_existente_apoyo }})">Accionar</button>
                    @else
                        {{ $apoyo->fecha_servicio->format('d/m/Y H:i:s') }} Hs.
                    @endif
                </td>

                <td>
                    @if ($apoyo->fecha_base == null)
                        <button class="btn btn-primary" wire:click="horaAccion(4, {{ $apoyo->idservicio_existente_apoyo }})">Accionar</button>
                    @else
                        {{ $apoyo->fecha_base->format('d/m/Y H:i:s') }} Hs.
                    @endif
                </td>

                <td>
                    @if (is_null($apoyo->km_final) and $apoyo->desperfecto === null)
                        <button class="btn btn-success btn-block"
                            wire:click="mostrarFormAgregarDetalleFuntion({{ $apoyo->idservicio_existente_apoyo }})">
                            <i
                                class="fas fa-{{ $mostrarFormAgregarDetalle && $apoyo_seleccionado_id === $apoyo->idservicio_existente_apoyo ? 'minus' : 'plus' }} mr-1"></i>
                            {{ $mostrarFormAgregarDetalle && $apoyo_seleccionado_id === $apoyo->idservicio_existente_apoyo ? 'Cancelar' : 'Agregar' }}
                        </button>
                    @else
                        {{ isset($apoyo->km_final) ? number_format($apoyo->km_final, 0, ',', '.') . ' Km' : ($apoyo->desperfecto ? '10.77' : 'NO') }}
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
            </tr>
        @endforelse
        <x-slot name="paginacion">
            {{ $apoyos->links() }}
        </x-slot>
    </x-table.table>
</div>
