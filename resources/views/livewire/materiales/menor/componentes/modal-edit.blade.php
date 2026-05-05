<form wire:submit.prevent="grabar">
    <div class="row col-md-12">
        {{-- Nombre --}}
        <x-adminlte-input name="nombre" wire:model.blur="nombre" oninput="this.value = this.value.toUpperCase()"
            placeholder="NOMBRE..." label-class="text-lightblue" fgroup-class="col-md-12" igroup-size="sm">
            <x-slot name="prependSlot">
                <div class="input-group-text">Nombre *</div>
            </x-slot>
        </x-adminlte-input>
    </div>

    {{-- SLOT DE FOOTER VACIO DEBIDO A QUE EL COMPONENTE DEL MODAL SE ENCUENTRA EN OTRA VISTA Y GENERA FALLO AL UTILIZAR METODOS DESDE AQUI --}}
    <x-slot name="footerSlot" class="p-0"></x-slot>

    <div class="modal-footer justify-content-between p-0">
        {{-- BOTON CERRAR MODAL --}}
        <x-adminlte-button label="Cerrar" class="btn-sm" data-dismiss="modal" theme="outline-secondary"
            icon="fas fa-arrow-left" />

        {{-- BOTON GUARDAR --}}
        <x-adminlte-button type="submit" label="Guardar" theme="outline-success" class="btn-sm" icon="fas fa-save" />
    </div>

</form>
