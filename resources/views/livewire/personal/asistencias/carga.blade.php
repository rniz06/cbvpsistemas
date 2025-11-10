<div>
    {{-- Modal --}}
    <x-adminlte-modal id="cargar-asistencia-{{ $asistencia_detalle_id }}" title="Cargar Asistencia" size="lg"
        static-backdrop icon="fas fa-tasks" theme="default" wire:ignore.self>
        
        <div class="col-md-12 row">
            {{-- Voluntario --}}
            <x-adminlte-input igroup-size="sm" name value="{{ $detalle->personal->nombrecompleto ?? '' }}" readonly
                fgroup-class="col-md-6">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Voluntario:</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Código --}}
            <x-adminlte-input igroup-size="sm" name value="{{ $detalle->personal->codigo ?? '' }}" readonly
                fgroup-class="col-md-6">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Código:</div>
                </x-slot>
            </x-adminlte-input>
        </div>

        <hr>

        {{-- FORMULARIO --}}
        <form wire:submit.prevent="grabar" class="col-md-12 row">
            {{-- Práctica --}}
            <x-adminlte-input type="number" name="practica" wire:model.blur="practica" igroup-size="sm"
                fgroup-class="col-md-4" placeholder="Porcentaje de 0 a 100">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Práctica:</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Guardia --}}
            <x-adminlte-input type="number" name="guardia" wire:model.blur="guardia" igroup-size="sm"
                fgroup-class="col-md-4" placeholder="Porcentaje de 0 a 100">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Guardia:</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Citación --}}
            <x-adminlte-input type="number" name="citacion" wire:model.blur="citacion" igroup-size="sm"
                fgroup-class="col-md-4" placeholder="Porcentaje de 0 a 100" :disabled="$asistencia->hubo_citacion == false">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Citación:</div>
                </x-slot>
            </x-adminlte-input>
        </form>

        {{-- Este slot debe ir FUERA del form --}}
        <x-slot name="footerSlot">
            <x-adminlte-button theme="outline-secondary" class="btn-sm" icon="fas fa-arrow-left" label="Cerrar"
                data-dismiss="modal" />
            <x-adminlte-button type="submit" form="cargar-asistencia-form-{{ $asistencia_detalle_id }}"
                theme="outline-success" class="btn-sm" icon="fas fa-save" label="Guardar" wire:click="grabar" />
        </x-slot>

    </x-adminlte-modal>
</div>
