
<div>
    <x-table.table titulo="Listado De Asistencia/Periodos" ocultarBuscador>

        <x-slot name="cabeceras">

            {{-- COMPAÑÍA --}}
            <th>
                @if (
                    Auth::user()->hasRole('personal_moderador_compania') ||
                    Auth::user()->hasRole('personal_moderador_por_compania')
                )
                    <x-adminlte-select
                        name="buscarCompaniaId"
                        label="Compañía:"
                        fgroup-class="col-md-12"
                        igroup-size="sm"
                        disabled
                    >
                        <option value="">Compañía asignada</option>
                    </x-adminlte-select>
                @else
                    <x-adminlte-select
                        name="buscarCompaniaId"
                        label="Compañía:"
                        fgroup-class="col-md-12"
                        wire:model.live.debounce.200ms="buscarCompaniaId"
                        igroup-size="sm"
                    >
                        <option value="">-- Todas --</option>

                        @foreach ($companias as $compania)
                            <option value="{{ $compania->id_compania }}">
                                {{ $compania->compania ?? 'S/D' }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                @endif
            </th>

            {{-- AÑO --}}
            <th>
                <x-adminlte-select
                    name="buscarAnhoId"
                    label="Año:"
                    fgroup-class="col-md-12"
                    wire:model.live.debounce.200ms="buscarAnhoId"
                    igroup-size="sm"
                >
                    <option value="">-- Todos --</option>

                    @foreach ($anhos as $anho)
                        <option value="{{ $anho->id_anho }}">
                            {{ $anho->anho ?? 'S/D' }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </th>

            {{-- MES --}}
            <th>
                <x-adminlte-select
                    name="buscarMesId"
                    label="Mes:"
                    fgroup-class="col-md-12"
                    wire:model.live.debounce.200ms="buscarMesId"
                    igroup-size="sm"
                >
                    <option value="">-- Todos --</option>

                    @foreach ($meses as $mes)
                        <option value="{{ $mes->id_mes }}">
                            {{ $mes->mes ?? 'S/D' }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </th>

            {{-- TIPO DE ASISTENCIA --}}
            <th>
                <x-adminlte-select
                    name="buscarTipoAsistencia"
                    label="Tipo:"
                    fgroup-class="col-md-12"
                    wire:model.live.debounce.200ms="buscarTipoAsistencia"
                    igroup-size="sm"
                >
                    <option value="">-- Todos --</option>

                    @foreach ($tiposAsistencia as $codigo => $descripcion)
                        <option value="{{ $codigo }}">
                            {{ $descripcion }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </th>

            
        {{-- Fecha de vencimiento --}}
        <th>
            <x-adminlte-input
                name=""
                label="Vencimiento:"
                fgroup-class="col-md-12"
                igroup-size="sm"
                readonly
            />
        </th>

        {{-- Estado del plazo o remisión --}}
        <th>
            <x-adminlte-input
                name=""
                label="Plazo / Remisión:"
                fgroup-class="col-md-12"
                igroup-size="sm"
                readonly
            />
        </th>


            {{-- ESTADO --}}
            <th>
                <x-adminlte-select
                    name="buscarEstadoId"
                    label="Estado:"
                    fgroup-class="col-md-12"
                    wire:model.live.debounce.200ms="buscarEstadoId"
                    igroup-size="sm"
                >
                    <option value="">-- Todos --</option>

                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id_asistencia_estado }}">
                            {{ $estado->estado ?? 'S/D' }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </th>

            {{-- ACCIONES --}}
            <th>
                <x-adminlte-input
                    name="acciones"
                    label="Acciones:"
                    fgroup-class="col-md-12"
                    igroup-size="sm"
                    readonly
                />
            </th>

        </x-slot>

        {{-- FILAS --}}
        @forelse ($asistencias as $asistencia)
            <tr>
                {{-- COMPAÑÍA --}}
                <td>
                    {{ $asistencia->compania->compania ?? 'N/A' }}
                </td>

                {{-- AÑO --}}
                <td>
                    {{ $asistencia->periodo->anho->anho ?? 'N/A' }}
                </td>

                {{-- MES --}}
                <td>
                    {{ $asistencia->periodo->mes->mes ?? 'N/A' }}
                </td>

                {{-- TIPO --}}
                <td>
                    @if ($asistencia->tipo_asistencia === 'P4')
                        <span class="badge badge-primary">
                            P4 - COMBATIENTES
                        </span>
                    @elseif ($asistencia->tipo_asistencia === 'P5')
                        <span class="badge badge-info">
                            P5 - ACTIVOS
                        </span>
                    @else
                        <span class="badge badge-secondary">
                            SIN TIPO ASIGNADO
                        </span>
                    @endif
                </td>


                
            {{-- Fecha de vencimiento del período --}}
            <td>
                @if ($asistencia->periodo?->fecha_vencimiento)
                    {{ \Carbon\Carbon::parse($asistencia->periodo->fecha_vencimiento)->format('d/m/Y') }}
                @else
                    <span class="text-muted">Sin fecha definida</span>
                @endif
            </td>

            {{-- Estado de plazo o remisión --}}
            <td>
                @php
                    $fechaVencimiento = $asistencia->periodo?->fecha_vencimiento;
                    $yaRemitida = in_array((int) $asistencia->estado_id, [3, 4]);
                @endphp

                @if ($yaRemitida)
                    <span class="badge badge-info">
                        YA SE REMITIÓ
                    </span>
                @elseif (!$fechaVencimiento)
                    <span class="badge badge-secondary">
                        SIN FECHA DEFINIDA
                    </span>
                @elseif (now()->startOfDay()->lte(
                    \Carbon\Carbon::parse($fechaVencimiento)->startOfDay()
                ))
                    <span class="badge badge-success">
                        EN PLAZO
                    </span>
                @else
                    <span class="badge badge-danger">
                        FUERA DE PLAZO
                    </span>
                @endif
            </td>

                {{-- ESTADO --}}
                <td>
                    {{ $asistencia->estado->estado ?? 'N/A' }}
                </td>

                {{-- ACCIONES --}}
                <td>
                    <div class="d-flex flex-wrap">

                        @can('Personal Asistencias Ver')
                            <a
                                href="{{ route('personal.asistencias.show', $asistencia->id_asistencia) }}"
                                class="btn btn-sm btn-outline-secondary mr-2 mb-1"
                            >
                                <i class="fas fa-eye"></i>
                                Ver
                            </a>
                        @endcan

                        @can('Personal Asistencia Eliminar')
                            @livewire(
                                'personal.asistencias.eliminar',
                                ['asistencia' => $asistencia->id_asistencia],
                                key($asistencia->id_asistencia)
                            )
                        @endcan

                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">
                    Sin resultados coincidentes...
                </td>
            </tr>
        @endforelse

        <x-slot name="paginacion">
            {{ $asistencias->links() }}
        </x-slot>

    </x-table.table>
</div>
