<div>
    {{-- Formulario --}}
    <x-adminlte-card theme="light" title="Añadir Usuario" icon="fas fa-plus-circle" header-class="text-muted text-sm">
        <form class="row col-md-12 p-2" wire:submit="guardar">

            {{-- Compañia --}}
            <x-adminlte-select name="compania_id" wire:model.blur="compania_id" label-class="text-lightblue"
                fgroup-class="col-md-4" igroup-size="sm">
                <option value="">-- Seleccionar --</option>
                @foreach ($companias as $compania)
                    <option value="{{ $compania->id_compania ?? 'S/D' }}">{{ $compania->compania ?? 'S/D' }}</option>
                @endforeach
                <x-slot name="prependSlot">
                    <div class="input-group-text">Compañia *</div>
                </x-slot>
            </x-adminlte-select>

            {{-- Periodo --}}
            <x-adminlte-select name="periodo_id" wire:model.blur="periodo_id" label-class="text-lightblue"
                fgroup-class="col-md-4" igroup-size="sm">
                <option value="">-- Seleccionar --</option>
                @foreach ($periodos as $periodo)
                    <option value="{{ $periodo->id_asistencia_periodo ?? 'S/D' }}">{{ $periodo->mes->mes ?? 'S/D' }}/{{ $periodo->anho->anho ?? 'S/D' }}</option>
                @endforeach
                <x-slot name="prependSlot">
                    <div class="input-group-text">Periodo *</div>
                </x-slot>
            </x-adminlte-select>

            {{-- Estado --}}
            <x-adminlte-select name="estado_id" wire:model.blur="estado_id" label-class="text-lightblue"
                fgroup-class="col-md-4" igroup-size="sm">
                <option value="">-- Seleccionar --</option>
                @foreach ($estados as $estado)
                    <option value="{{ $estado->id_asistencia_estado ?? 'S/D' }}">{{ $estado->estado ?? 'S/D' }}</option>
                @endforeach
                <x-slot name="prependSlot">
                    <div class="input-group-text">Estado *</div>
                </x-slot>
            </x-adminlte-select>

            {{-- Botón de Volver --}}
            <div class="form-group col-md-3 d-flex align-items-end">
                <a href="{{ route('personal.asistencias.index') }}"
                    class="btn btn-block btn-outline-secondary text-decoration-none btn-sm"><i
                        class="fas fa-arrow-left mr-1"></i>Volver a vista de Asistencias</a>
            </div>
            {{-- Botón de Guardar --}}
            <div class="form-group col-md-3 d-flex align-items-end">
                <x-adminlte-button type="submit" label="Guardar" theme="outline-success" icon="fas fa-lg fa-save"
                    class="w-100 btn-sm" />
            </div>
        </form>
    </x-adminlte-card>
</div>