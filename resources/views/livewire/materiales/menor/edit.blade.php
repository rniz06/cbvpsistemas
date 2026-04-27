<form wire:submit.prevent="guardar" class="row">
    {{-- COMPONENTE --}}
    <x-adminlte-input name="" label-class="text-lightblue" fgroup-class="col-md-4"
        value="{{ $registro->componente->nombre ?? 'S/D' }}" readonly>
        <x-slot name="prependSlot">
            <div class="input-group-text">Item *</div>
        </x-slot>
    </x-adminlte-input>

    {{-- CANTIDAD OPERATIVO --}}
    <x-adminlte-input name="cantidad_operativo" wire:model.blur="cantidad_operativo" type="number" placeholder="EJ: 0"
        label-class="text-lightblue" fgroup-class="col-md-4">
        <x-slot name="prependSlot">
            <div class="input-group-text">Cant. Operativo *</div>
        </x-slot>
    </x-adminlte-input>

    {{-- CANTIDAD INOPERATIVO --}}
    <x-adminlte-input name="cantidad_inoperativo" wire:model.blur="cantidad_inoperativo" type="number"
        placeholder="EJ: 0" label-class="text-lightblue" fgroup-class="col-md-4">
        <x-slot name="prependSlot">
            <div class="input-group-text">Cant. Inoperativo *</div>
        </x-slot>
    </x-adminlte-input>


    <div class="modal-footer">
        <x-adminlte-button type="submit" theme="outline-success" icon="fas fa-save" class="btn-sm" label="Guardar cambios" />
        <x-adminlte-button theme="outline-secondary" label="Cerrar" icon="fas fa-window-close" class="btn-sm" data-dismiss="modal" />
    </div>

</form>
