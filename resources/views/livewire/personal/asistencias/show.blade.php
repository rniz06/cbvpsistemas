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
        <x-adminlte-callout theme="warning" title="Acciones" class="col-md-12">

            @if ($bloqueo_enviar_dpto_personal)
                <x-adminlte-button label="Enviar a Dpto de Personal" icon="fas fa-pencil-alt" theme="outline-success"
                    class="btn-sm" disabled />
            @else
                <x-adminlte-button label="Enviar a Dpto de Personal" icon="fas fa-pencil-alt" theme="outline-success"
                    class="btn-sm" wire:click="enviarDptoPersonal"
                    wire:confirm="¿ESTAS SEGURO QUE DESEAS REMITIR LA PLANILLA DE ASISTENCIA AL DEPARTAMENTO DE PERSONAL?" />
            @endif

            @if ($bloqueo_aprobar_derivar_comandancia)
                <x-adminlte-button label="Aprobar y derivar a Comandancia" icon="fas fa-pencil-alt"
                    theme="outline-success" class="btn-sm" disabled />
            @else
                <x-adminlte-button label="Aprobar y derivar a Comandancia" icon="fas fa-pencil-alt"
                    theme="outline-success" class="btn-sm" wire:click="aprobarDerivarComandancia"
                    wire:confirm="¿ESTAS SEGURO QUE DESEAS APROBAR Y DERIVAR A COMANDANCIA?" />
            @endif

            @if ($bloqueo_aprobar_derivar_comandancia)
                <x-adminlte-button label="Rechazar y derivar a la Compañia" icon="fas fa-pencil-alt"
                    theme="outline-success" class="btn-sm" disabled />
            @else
                <x-adminlte-button label="Rechazar y derivar a la Compañia" icon="fas fa-pencil-alt"
                    theme="outline-danger" class="btn-sm" wire:click="rechazarDerivarCompania"
                    wire:confirm="¿ESTAS SEGURO QUE DESEAS RECHAZAR Y DERIVAR LA PLANILLA DEVUELTA A LA COMPAÑIA?" />
            @endif

            @if ($bloqueo_aprobar_comandancia)
                <x-adminlte-button label="Aprobado por Comandancia" icon="fas fa-pencil-alt" theme="outline-success"
                    class="btn-sm" disabled />
            @else
                <x-adminlte-button label="Aprobado por Comandancia" icon="fas fa-pencil-alt" theme="outline-success"
                    class="btn-sm" wire:click="aprobadoComandancia"
                    wire:confirm="ESTAS SEGURO QUE DESEAS DAR LA APROBACION FINAL A ESTE PERIODO DE ASISTENCIA?" />
            @endif

            @if ($bloqueo_aprobar_comandancia)
                <x-adminlte-button label="Rechazar y derivar al Dpto de Personal" icon="fas fa-pencil-alt"
                    theme="outline-success" class="btn-sm" disabled />
            @else
                <x-adminlte-button label="Rechazar y derivar al Dpto de Personal" icon="fas fa-pencil-alt"
                    theme="outline-danger" class="btn-sm" wire:click="rechazarDerivarDptoPersonal"
                    wire:confirm="¿ESTAS SEGURO QUE DESEAS RECHAZAR Y DERIVAR LA PLANILLA DEVUELTA A LA COMPAÑIA AL DEPARTAMENTO DE PERSONAL?" />
            @endif
        </x-adminlte-callout>
    </div>
</div>
