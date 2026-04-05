<div>
    {{-- FORMULARIO DE ALTA DE MENOR MARCA --}}
    <x-adminlte-modal id="modal-create-marca" title="Agregar Marca" size="lg" static-backdrop icon="fas fa-tasks"
        theme="default" wire:ignore.self>

        <div class="row col-md-12">
            {{-- Nombre --}}
            <x-adminlte-input name="nombre" wire:model.blur="nombre" oninput="this.value = this.value.toUpperCase()"
                placeholder="NOMBRE..." label-class="text-lightblue" fgroup-class="col-md-12" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Nombre *</div>
                </x-slot>
            </x-adminlte-input>
        </div>


        {{-- Modal Footer --}}
        <x-slot name="footerSlot">
            <x-adminlte-button class="btn-sm" type="button" label="Guardar" theme="outline-success" icon="fas fa-save"
                wire:click="grabar" />

            <x-adminlte-button theme="outline-secondary" class="btn-sm" icon="fas fa-arrow-left" label="Cerrar"
                data-dismiss="modal" wire:click="resetForm" />
        </x-slot>

    </x-adminlte-modal>
</div>