<div>
    {{-- Themed --}}
    <x-adminlte-modal id="modal-rechazo-personal" title="Recharzar Asistencia" theme="default" icon="fas fa-edit"
        size='lg' static-backdrop v-centered wire:ignore.self>
        <div class="row col-md-12">

            {{-- Comentario --}}
            <x-adminlte-textarea name="comentario" wire:model.blur="comentario"
                oninput="this.value = this.value.toUpperCase()" fgroup-class="col-md-12">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Motivo del Rechazo *</div>
                </x-slot>
            </x-adminlte-textarea>

        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button type="button" class="btn-sm mr-auto" theme="outline-secondary" label="Cerrar"
                icon="fas fa-window-close" data-dismiss="modal" wire:click="$dispatch('cerrar-modal')" />

            <x-adminlte-button type="button" class="btn-sm" theme="outline-success" label="Guardar" icon="fas fa-save"
                wire:click="guardar" />
        </x-slot>
    </x-adminlte-modal>

    {{-- Botón para abrir modal --}}
    <x-adminlte-button label="Rechazar y derivar a la Compañia" icon="fas fa-pencil-alt" data-toggle="modal"
        data-target="#modal-rechazo-personal" theme="outline-danger" class="btn-sm" />
</div>
