
<div>
    <style>
        /* Información de la asistencia */
        .asistencia-info .callout {
            margin-bottom: 12px;
            padding: 12px 15px;
            min-height: 85px;
        }

        .asistencia-info .callout h5 {
            font-size: 15px;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 8px;
        }

        .asistencia-info .callout p,
        .asistencia-info .callout div,
        .asistencia-info .callout strong {
            font-size: 14px;
            line-height: 1.5;
        }

        .asistencia-info .badge {
            font-size: 12px;
            padding: 5px 8px;
        }

        /* Acciones en un bloque independiente */
        .asistencia-acciones .callout {
            padding: 12px 15px;
            margin-bottom: 12px;
        }

        .asistencia-acciones .callout h5 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .asistencia-acciones .btn {
            font-size: 13px;
            padding: 7px 12px;
            margin: 0 6px 5px 0;
        }

        /* En móviles, los bloques se acomodan verticalmente */
        @media (max-width: 767.98px) {
            .asistencia-info .callout {
                min-height: auto;
            }
        }
    </style>

    {{-- FILA 1: COMPAÑÍA, PERÍODO Y TIPO --}}
    <div class="row asistencia-info">

        {{-- COMPAÑÍA --}}
        <x-adminlte-callout
            theme="warning"
            title="Compañía"
            class="col-md-4"
        >
            {{ $asistencia->compania->compania ?? 'S/D' }}
        </x-adminlte-callout>

        {{-- PERÍODO --}}
        <x-adminlte-callout
            theme="warning"
            title="Período"
            class="col-md-4"
        >
            {{ $asistencia->periodo->mes->mes ?? 'S/D' }}
            /
            {{ $asistencia->periodo->anho->anho ?? 'S/D' }}
        </x-adminlte-callout>

        {{-- TIPO DE ASISTENCIA --}}
        <x-adminlte-callout
            theme="info"
            title="Tipo de asistencia"
            class="col-md-4"
        >
            @if ($asistencia->tipo_asistencia === 'P4')
                <strong>P4 — COMBATIENTES</strong>
            @elseif ($asistencia->tipo_asistencia === 'P5')
                <strong>P5 — ACTIVOS</strong>
            @else
                <strong>SIN TIPO ASIGNADO</strong>
            @endif
        </x-adminlte-callout>

    </div>

    {{-- FILA 2: ESTADO, LÍMITE Y PLAZO --}}
    <div class="row asistencia-info">

        {{-- ESTADO --}}
        <x-adminlte-callout
            theme="warning"
            title="Estado"
            class="col-md-4"
        >
            {{ $asistencia->estado->estado ?? 'S/D' }}
        </x-adminlte-callout>

        {{-- LÍMITE DE PRESENTACIÓN --}}
        <x-adminlte-callout
            theme="warning"
            title="Límite de presentación"
            class="col-md-4"
        >
            @if ($asistencia->periodo?->fecha_vencimiento)
                {{ \Carbon\Carbon::parse($asistencia->periodo->fecha_vencimiento)->format('d/m/Y') }}
            @else
                SIN FECHA DEFINIDA
            @endif
        </x-adminlte-callout>

        {{-- PLAZO / REMISIÓN --}}
        <x-adminlte-callout
            theme="success"
            title="Plazo / Remisión"
            class="col-md-4"
        >
            @php
                $fechaVencimiento = $asistencia->periodo?->fecha_vencimiento;

                $yaFueRemitida = in_array(
                    (int) $asistencia->estado_id,
                    [3, 4, 7],
                    true
                );
            @endphp

            @if ($yaFueRemitida)
                <span class="badge badge-info">REMITIDA</span>
            @elseif (!$fechaVencimiento)
                <span class="badge badge-secondary">SIN FECHA</span>
            @elseif (
                now()->startOfDay()->lte(
                    \Carbon\Carbon::parse($fechaVencimiento)->startOfDay()
                )
            )
                <span class="badge badge-success">EN PLAZO</span>
            @else
                <span class="badge badge-danger">VENCIDA</span>
            @endif
        </x-adminlte-callout>

    </div>

    {{-- ACCIONES: BLOQUE SEPARADO --}}
    <div class="row asistencia-acciones">

        <x-adminlte-callout
            theme="warning"
            title="Acciones"
            class="col-md-12"
        >

            {{-- ENVIAR A DEPARTAMENTO DE PERSONAL --}}
            @can('Personal Asistencias Enviar a Dpto de Personal')
                @if ($bloqueo_enviar_dpto_personal)
                    <x-adminlte-button
                        label="Enviar a Dpto. de Personal"
                        icon="fas fa-pencil-alt"
                        theme="outline-success"
                        class="btn-sm"
                        disabled
                    />
                @else
                    <x-adminlte-button
                        label="Enviar a Dpto. de Personal"
                        icon="fas fa-pencil-alt"
                        theme="outline-success"
                        class="btn-sm"
                        wire:click="enviarDptoPersonal"
                        wire:confirm="¿ESTÁS SEGURO DE REMITIR LA PLANILLA AL DEPARTAMENTO DE PERSONAL?"
                    />
                @endif
            @endcan

            {{-- APROBAR --}}
            @can('Personal Asistencias Aprobar')
                @if ($bloqueo_aprobar_dpto_personal)
                    <x-adminlte-button
                        label="Aprobar Dpto. Personal"
                        icon="fas fa-pencil-alt"
                        theme="outline-success"
                        class="btn-sm"
                        disabled
                    />
                @else
                    <x-adminlte-button
                        label="Aprobar Dpto. Personal"
                        icon="fas fa-pencil-alt"
                        theme="outline-success"
                        class="btn-sm"
                        wire:click="aprobarDptoPersonal"
                        wire:confirm="¿ESTÁS SEGURO DE APROBAR ESTA PLANILLA DE ASISTENCIA?"
                    />
                @endif
            @endcan

            {{-- RECHAZAR Y DERIVAR A LA COMPAÑÍA --}}
            @can('Personal Asistencias Rechazar y derivar a la Compania')
                @if ($bloqueo_aprobar_dpto_personal)
                    <x-adminlte-button
                        label="Rechazar y derivar a la Compañía"
                        icon="fas fa-pencil-alt"
                        theme="outline-success"
                        class="btn-sm"
                        disabled
                    />
                @else
                    @livewire(
                        'personal.asistencias.modal-rechazo-personal',
                        ['asistencia' => $asistencia->id_asistencia],
                        key('rechazo-' . $asistencia->id_asistencia)
                    )
                @endif
            @endcan

            {{-- HABILITAR O CANCELAR CITACIÓN --}}
            @can('Personal Asistencias Habilitar Citacion')
                @if ($asistencia->hubo_citacion)
                    <x-adminlte-button
                        label="Cancelar Citación"
                        icon="fas fa-pencil-alt"
                        theme="outline-danger"
                        class="btn-sm"
                        wire:click="cancelar_citacion"
                        :disabled="$asistencia->estado_id != 2"
                        wire:confirm="¿ESTÁS SEGURO DE CANCELAR LAS CITACIONES?"
                    />
                @else
                    <x-adminlte-button
                        label="Habilitar Citación"
                        icon="fas fa-pencil-alt"
                        theme="outline-success"
                        class="btn-sm"
                        wire:click="habilitar_citacion"
                        wire:confirm="¿ESTÁS SEGURO DE HABILITAR EL CAMPO DE CITACIÓN?"
                    />
                @endif
            @endcan

        </x-adminlte-callout>

    </div>
</div>
