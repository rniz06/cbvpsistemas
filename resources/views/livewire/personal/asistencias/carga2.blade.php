<div>
    {{-- Formulario --}}
    <x-adminlte-card theme="light"
        title="Cargar Asistencia del voluntario {{ $detalle->personal->nombrecompleto ?? 'S/D' }} con Código {{ $detalle->personal->codigo ?? 'S/D' }}"
        icon="fas fa-plus-circle" header-class="text-muted text-sm">
        <form class="row col-md-12 p-2" wire:submit="guardar">

            {{-- Práctica --}}
            <x-adminlte-input type="number" name="practica" wire:model.blur="practica"
                placeholder="Porcetanje de 0 a 100" label-class="text-lightblue" fgroup-class="col-md-4" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Práctica *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Guardia --}}
            <x-adminlte-input type="number" name="guardia" wire:model.blur="guardia"
                placeholder="Porcetanje de 0 a 100" label-class="text-lightblue" fgroup-class="col-md-4" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Guardia *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Citación --}}
            <x-adminlte-input type="number" name="citacion" wire:model.blur="citacion" :disabled="$bloqueoCitacion"
                placeholder="Porcetanje de 0 a 100" label-class="text-lightblue" fgroup-class="col-md-4" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Citación *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Botón de Volver --}}
            <div class="form-group col-md-3 d-flex align-items-end">
                <a href="{{ route('personal.asistencias.show', $detalle->asistencia_id) }}" class="btn btn-block btn-outline-secondary text-decoration-none btn-sm"><i
                        class="fas fa-arrow-left mr-1"></i>Cancelar</a>
            </div>
            {{-- Botón de Guardar --}}
            <div class="form-group col-md-3 d-flex align-items-end">
                <x-adminlte-button type="submit" label="Guardar" theme="outline-success" icon="fas fa-lg fa-save"
                    class="w-100 btn-sm" />
            </div>
        </form>
    </x-adminlte-card>
</div>
