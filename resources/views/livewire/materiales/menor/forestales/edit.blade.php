<div>
    {{-- Formulario --}}
    <x-adminlte-card theme="light" title="Editar Equipo Forestal" icon="fas fa-edit" header-class="text-muted text-sm">
        <form class="col-md-12 row" wire:submit="guardar">

            {{-- COMPONENTE --}}
            <x-adminlte-input name="" label-class="text-lightblue" fgroup-class="col-md-3"
                value="{{ $registro->componente->nombre ?? 'S/D' }}" readonly>
                <x-slot name="prependSlot">
                    <div class="input-group-text">Item *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- CANTIDAD OPERATIVO --}}
            <x-adminlte-input name="cantidad_operativo" wire:model.blur="cantidad_operativo" type="number"
                placeholder="EJ: 0" label-class="text-lightblue" fgroup-class="col-md-3">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Cant. Operativo *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- CANTIDAD INOPERATIVO --}}
            <x-adminlte-input name="cantidad_inoperativo" wire:model.blur="cantidad_inoperativo" type="number"
                placeholder="EJ: 0" label-class="text-lightblue" fgroup-class="col-md-3">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Cant. Inoperativo *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Botón de Guardar --}}
            <div class="form-group col-xl-3 d-flex align-items-end">
                <x-adminlte-button type="submit" label="Guardar" theme="outline-success" icon="fas fa-lg fa-save"
                    class="w-100" />
            </div>
        </form>
    </x-adminlte-card>
</div>
