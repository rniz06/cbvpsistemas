<div>
    {{-- Tabla de Comisionamientos --}}
    <x-table.table titulo="Listado De Asistencia/Periodos" ocultarBuscador>

        <x-slot name="cabeceras">

            {{-- Companias --}}
            <th>
                <div>
                    <x-adminlte-select name="" label="Compañia:" fgroup-class="col-md-12"
                        wire:model.live.debounce.200ms="buscarCompaniaId" igroup-size="sm">
                        <option value="">-- Todos --</option>
                        @foreach ($companias as $compania)
                            <option value="{{ $compania->id_compania }}">{{ $compania->compania ?? 'S/D' }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            </th>

            {{-- Año --}}
            <th>
                <div>
                    <x-adminlte-select name="" label="Año:" fgroup-class="col-md-12"
                        wire:model.live.debounce.200ms="buscarAnhoId" igroup-size="sm">
                        <option value="">-- Todos --</option>
                        @foreach ($anhos as $anho)
                            <option value="{{ $anho->id_anho }}">{{ $anho->anho ?? 'S/D' }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            </th>

            {{-- Mes --}}
            <th>
                <div>
                    <x-adminlte-select name="" label="Mes:" fgroup-class="col-md-12"
                        wire:model.live.debounce.200ms="buscarMesId" igroup-size="sm">
                        <option value="">-- Todos --</option>
                        @foreach ($meses as $mes)
                            <option value="{{ $mes->id_mes }}">{{ $mes->mes ?? 'S/D' }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            </th>

            {{-- Estado --}}
            <th>
                <div>
                    <x-adminlte-select name="" label="Estado:" fgroup-class="col-md-12"
                        wire:model.live.debounce.200ms="buscarEstadoId" igroup-size="sm">
                        <option value="">-- Todos --</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id_asistencia_estado }}">{{ $estado->estado ?? 'S/D' }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            </th>

            <th>
                <div>
                    <x-adminlte-input name="" label="Acciones:" fgroup-class="col-md-12" igroup-size="sm"
                        readonly />
                </div>
            </th>

        </x-slot>
        @forelse ($asistencias as $asistencia)
            <tr>
                <td>{{ $asistencia->compania->compania ?? 'N/A' }}</td>
                <td>{{ $asistencia->periodo->anho->anho ?? 'N/A' }}</td>
                <td>{{ $asistencia->periodo->mes->mes ?? 'N/A' }}</td>
                <td>{{ $asistencia->estado->estado ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('personal.asistencias.show', $asistencia->id_asistencia) }}"
                        class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i> Ver</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
            </tr>
        @endforelse
        <x-slot name="paginacion">
            {{ $asistencias->links() }}
        </x-slot>
    </x-table.table>
</div>
