<div>
    <h4>Servicios Del Móvil : <span class="badge badge-secondary">{{ $movil->tipo ?? 'S/D' }}-{{ $movil->movil ?? 'S/D' }}</span></h4>
    <p class="font-weight-bold font-italic">Obs: Este listado Incluye servicios activos y culminados</p>

    <x-table.table titulo="Servicios" ocultarBuscador>
        <x-slot name="headerBotones">

            <x-adminlte-button wire:click="excel" label="Excel" theme="outline-success" class="btn-sm"
                icon="fas fa-file-excel" />

            <x-adminlte-button wire:click="pdf" label="Pdf" theme="outline-secondary" class="btn-sm"
                icon="fas fa-file-pdf" />

        </x-slot>

        <x-slot name="cabeceras">
            <th>Tipo De Servicio:</th>
            <th>Fecha y Hora:</th>
            <th>Conductor:</th>
            <th>A cargo:</th>
        </x-slot>

        @foreach ($servicios as $servicio)
            <tr>
                <td>{{ $servicio->servicio ?? 'S/D' }}</td>
                <td>{{ date('d/m/Y H:i:s', strtotime($servicio->fecha_alfa)) }} Hs.</td>
                {{-- Chofer --}}
                <td>
                    @if ($servicio->chofer_rentado == 1)
                        <span class="badge badge-secondary">Rentado</span>
                    @elseif (!empty($servicio->chofer_nombrecompleto))
                        {{ $servicio->chofer_nombrecompleto ?? 'S/D' }} - {{ $servicio->chofer_codigo ?? 'S/D' }} -
                        {{ $servicio->chofer_categoria ?? 'S/D' }}
                    @elseif (!empty($servicio->chofer_aux))
                        {{ $servicio->chofer_aux }}
                    @else
                        S/D
                    @endif
                </td>

                {{-- A cargo --}}
                <td>
                    @if (empty($servicio->acargo_nombrecompleto) && !empty($servicio->acargo_aux))
                        {{ $servicio->acargo_aux }}
                    @elseif (!empty($servicio->acargo_nombrecompleto))
                        {{ $servicio->acargo_nombrecompleto ?? 'S/D' }} - {{ $servicio->acargo_codigo ?? 'S/D' }} -
                        {{ $servicio->acargo_categoria ?? 'S/D' }}
                    @else
                        S/D
                    @endif
                </td>
            </tr>
        @endforeach
        <x-slot name="paginacion">
            {{ $servicios->links() }}
        </x-slot>
    </x-table.table>

</div>
