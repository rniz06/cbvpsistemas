<form wire:submit.prevent="guardar" class="row">

    <div class="col-md-12">{{ $ult_reg_operatividad ?? 's-d' }}</div>

    {{-- A cargo --}}
    <x-adminlte-input name="acargo" wire:model.blur="acargo" oninput="this.value = this.value.toUpperCase()"
        placeholder="Ej: C151 o 8699" label-class="text-lightblue" fgroup-class="col-md-3">
        <x-slot name="prependSlot">
            <div class="input-group-text">A cargo *</div>
        </x-slot>
    </x-adminlte-input>

    {{-- Personal --}}
    <x-adminlte-input name="cant_personal" wire:model.blur="cant_personal" type="number" placeholder="Ej: 1 o 5"
        label-class="text-lightblue" fgroup-class="col-md-3">
        <x-slot name="prependSlot">
            <div class="input-group-text">Personal *</div>
        </x-slot>
    </x-adminlte-input>

    {{-- Conductores --}}
    <x-adminlte-input name="cant_conductor" wire:model.blur="cant_conductor" type="number" placeholder="Ej: 1 o 5"
        label-class="text-lightblue" fgroup-class="col-md-3">
        <x-slot name="prependSlot">
            <div class="input-group-text">Conductores *</div>
        </x-slot>
    </x-adminlte-input>

    {{-- Equipo Hidraulico --}}
    <x-adminlte-select name="equipo_hidraulico" wire:model.blur="equipo_hidraulico" label-class="text-lightblue"
        fgroup-class="col-md-3">
        <option value="true">Operativo</option>
        <option value="false">Inoperativo</option>
        <x-slot name="prependSlot">
            <div class="input-group-text">E. Hidraulico *</div>
        </x-slot>
    </x-adminlte-select>

    {{-- Pileta --}}
    <x-adminlte-select name="pileta" wire:model.blur="pileta" label-class="text-lightblue" fgroup-class="col-md-3">
        <option value="1">Operativo</option>
        <option value="0">Inoperativo</option>
        <x-slot name="prependSlot">
            <div class="input-group-text">Pileta *</div>
        </x-slot>
    </x-adminlte-select>

    {{-- Autónomo --}}
    <x-adminlte-input name="cant_autonomo" wire:model.blur="cant_autonomo" type="number" placeholder="Ej: 1 o 12"
        label-class="text-lightblue" fgroup-class="col-md-3">
        <x-slot name="prependSlot">
            <div class="input-group-text">Autónomo *</div>
        </x-slot>
    </x-adminlte-input>

    {{-- Espuma --}}
    <x-adminlte-input name="cant_espuma" wire:model.blur="cant_espuma" type="number" placeholder="Ej: 1 o 12"
        label-class="text-lightblue" fgroup-class="col-md-3">
        <x-slot name="prependSlot">
            <div class="input-group-text">Espuma *</div>
        </x-slot>
        <x-slot name="bottomSlot">
            <span class="text-sm text-gray">
                [Cantidad de espuma en litros]
            </span>
        </x-slot>
    </x-adminlte-input>

    <div class="col-md-3"></div>

    <div class="modal-footer col-md-12">
        <x-adminlte-button type="submit" theme="outline-success" icon="fas fa-save" class="btn-sm col-md-3"
            label="Guardar" />
        <x-adminlte-button theme="outline-secondary" label="Cerrar" icon="fas fa-window-close" class="btn-sm col-md-3"
            data-dismiss="modal" wire:click="resetForm" />
    </div>
</form>
