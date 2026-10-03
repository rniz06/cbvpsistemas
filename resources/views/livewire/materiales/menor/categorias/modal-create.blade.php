<form wire:submit.prevent="guardar" class="row">

        {{-- Nombre --}}
        <x-adminlte-input name="nombre" wire:model.blur="nombre" oninput="this.value = this.value.toUpperCase()"
            placeholder="NOMBRE..." label-class="text-lightblue" fgroup-class="col-md-12">
            <x-slot name="prependSlot">
                <div class="input-group-text">Nombre *</div>
            </x-slot>
        </x-adminlte-input>

    <div class="modal-footer">
        <x-adminlte-button type="submit" theme="outline-success" icon="fas fa-save" class="btn-sm"
            label="Guardar" />
        <x-adminlte-button theme="outline-secondary" label="Cerrar" icon="fas fa-window-close" class="btn-sm"
            data-dismiss="modal" wire:click="resetForm" />
    </div>
</form>
