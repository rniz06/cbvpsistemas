<div>
    {{-- AAA ID: {{ $asistencia }} --}}
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
    </div>
</div>
