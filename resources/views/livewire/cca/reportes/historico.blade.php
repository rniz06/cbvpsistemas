<div>
    {{ $fecha_desde ?? 'S/D'}}
    <br>
    {{ $fecha_hasta ?? 'S/D'}}
    <br>
    {{ $compania_id ?? 'S/D'}}
    <br>
    {{ $servicio_id ?? 'S/D'}}
    <br>
    {{ $clasificacion_id ?? 'S/D'}}

    {{-- Tabla de Reportes --}}
    {{-- Filtros de Búsqueda --}}
    <x-card.card-filtro>
        <div class="row">

            {{-- Fecha Desde --}}
            <x-adminlte-input name="fecha_desde" type="date" wire:model.live="fecha_desde" label="Desde:"
                fgroup-class="col-md-2" />

            {{-- Fecha Hasta --}}
            <x-adminlte-input name="fecha_hasta" type="date" wire:model.live="fecha_hasta" label="Hasta:"
                fgroup-class="col-md-2" />

            {{-- Companias --}}
            <div class="col-md-2">
                <x-adminlte-select name="compania_id" label="Compañias:" wire:model.live.debounce.250ms="compania_id">
                    <option>Todos</option>
                    @foreach ($companias as $compania)
                        <option value="{{ $compania->id_compania }}">
                            {{ $compania->compania ?? 'S/D' }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            {{-- Servicios --}}
            <div class="col-md-2">
                <x-adminlte-select name="servicio_id" label="Servicio:" wire:model.live.debounce.250ms="servicio_id">
                    <option>Todos</option>
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id_servicio }}">
                            {{ $servicio->servicio ?? 'S/D' }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            {{-- Clasificaciones --}}
            <div class="col-md-2">
                <x-adminlte-select name="clasificacion_id" label="Clasificación:"
                    wire:model.live.debounce.250ms="clasificacion_id">
                    <option>Todos</option>
                    @foreach ($clasificaciones as $clasificacion)
                        <option value="{{ $clasificacion->id_servicio_clasificacion }}">
                            {{ $clasificacion->clasificacion ?? 'S/D' }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

        </div>
    </x-card.card-filtro>
</div>
