<form wire:submit.prevent="guardar">

    {{-- VOLUNTARIO --}}
    <div class="row col-md-12">
        <x-adminlte-input
            name="voluntario"
            label="Voluntario"
            fgroup-class="col-md-12"
            igroup-size="sm"
            readonly
            value="{{ $detalle->personal->nombrecompleto . ' | Código: ' . $detalle->personal->codigo }}"
        />
    </div>

    <div class="row col-md-12">

        {{-- PRÁCTICA: SOLO PARA P4 --}}
        @if ($detalle->asistencia->tipo_asistencia !== 'P5')
            <x-adminlte-input
                type="number"
                name="practica"
                wire:model.blur="practica"
                label="Práctica *"
                fgroup-class="col-md-4"
                igroup-size="sm"
                min="0"
                max="100"
                step="0.01"
            />
        @endif

        {{-- GUARDIA: P4 Y P5 --}}
        <x-adminlte-input
            type="number"
            name="guardia"
            wire:model.blur="guardia"
            label="Guardia *"
            fgroup-class="{{ $detalle->asistencia->hubo_citacion ? 'col-md-4' : ($detalle->asistencia->tipo_asistencia === 'P5' ? 'col-md-12' : 'col-md-4') }}"
            igroup-size="sm"
            min="0"
            max="100"
            step="0.01"
        />

        {{-- CITACIÓN: SOLO SI ESTÁ HABILITADA --}}
        @if ($detalle->asistencia->hubo_citacion)
            <x-adminlte-input
                type="number"
                name="citacion"
                wire:model.blur="citacion"
                label="Citación *"
                fgroup-class="col-md-4"
                igroup-size="sm"
                min="0"
                max="100"
                step="0.01"
            />
        @endif

    </div>

    <x-slot name="footerSlot" class="p-0"></x-slot>

    <div class="modal-footer justify-content-between p-0">

        <x-adminlte-button
            label="Cerrar"
            class="btn-sm"
            data-dismiss="modal"
            theme="outline-secondary"
            icon="fas fa-arrow-left"
            onclick="this.blur()"
        />

        <x-adminlte-button
            type="submit"
            label="Guardar"
            theme="outline-success"
            class="btn-sm"
            icon="fas fa-save"
        />

    </div>
</form>