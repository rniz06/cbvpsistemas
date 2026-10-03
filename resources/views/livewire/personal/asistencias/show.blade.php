<div>
    <div class="col-md-12 row">

        {{-- Compañia --}}
        <x-adminlte-callout theme="warning" title="Compañia" class="col-md-4">
            {{ $asistencia->compania->compania ?? 'S/D' }}
        </x-adminlte-callout>

        {{-- Periodo --}}
        <x-adminlte-callout theme="warning" title="Periodo" class="col-md-4">
            {{ $asistencia->periodo->mes->mes ?? 'S/D' }} / {{ $asistencia->periodo->anho->anho ?? 'S/D' }}
        </x-adminlte-callout>

        {{-- Estado --}}
        <x-adminlte-callout theme="warning" title="Estado" class="col-md-4">
            {{ $asistencia->estado->estado ?? 'S/D' }}
        </x-adminlte-callout>

        {{-- Acciones --}}
        <x-adminlte-callout theme="warning" title="Acciones:" class="col-md-12">

            @can('Personal Asistencias Enviar a Dpto de Personal')
                @if ($bloqueo_enviar_dpto_personal)
                    <x-adminlte-button label="Enviar a Dpto de Personal" icon="fas fa-pencil-alt" theme="outline-success"
                        class="btn-sm" disabled />
                @else
                    <x-adminlte-button label="Enviar a Dpto de Personal" icon="fas fa-pencil-alt" theme="outline-success"
                        class="btn-sm" wire:click="enviarDptoPersonal"
                        wire:confirm="¿ESTAS SEGURO QUE DESEAS REMITIR LA PLANILLA DE ASISTENCIA AL DEPARTAMENTO DE PERSONAL?" />
                @endif
            @endcan

            @can('Personal Asistencias Aprobar')
                @if ($bloqueo_aprobar_dpto_personal)
                    <x-adminlte-button label="Aprobar Dpto. Personal" icon="fas fa-pencil-alt" theme="outline-success"
                        class="btn-sm" disabled />
                @else
                    <x-adminlte-button label="Aprobar Dpto. Personal" icon="fas fa-pencil-alt" theme="outline-success"
                        class="btn-sm" wire:click="aprobarDptoPersonal"
                        wire:confirm="¿ESTAS SEGURO QUE DESEAS APROBAR ESTA PERIODO DE ASISTENCIA?" />
                @endif
            @endcan

            @can('Personal Asistencias Rechazar y derivar a la Compania')
                @if ($bloqueo_aprobar_dpto_personal)
                    <x-adminlte-button label="Rechazar y derivar a la Compañia" icon="fas fa-pencil-alt"
                        theme="outline-success" class="btn-sm" disabled />
                @else
                    @livewire('personal.asistencias.modal-rechazo-personal', ['asistencia' => $asistencia->id_asistencia], key($asistencia->id_asistencia))
                @endif
            @endcan

            @can('Personal Asistencias Habilitar Citacion')
                @if ($asistencia->hubo_citacion == true)
                    <x-adminlte-button label="Cancelar Citación" icon="fas fa-pencil-alt" theme="outline-danger"
                        class="btn-sm" wire:click="cancelar_citacion" :disabled="$asistencia->estado_id != 2"
                        wire:confirm="¿ESTAS SEGURO QUE DESEAS CANCELAR LAS CITACIONES?" />
                @else
                    <x-adminlte-button label="Habilitar Citación" icon="fas fa-pencil-alt" theme="outline-success"
                        class="btn-sm" wire:click="habilitar_citacion"
                        wire:confirm="¿ESTAS SEGURO QUE DESEAS HABILITAR EL CAMPO DE CITACIÓN?" />
                @endif
            @endcan
        </x-adminlte-callout>
    </div>
</div>
