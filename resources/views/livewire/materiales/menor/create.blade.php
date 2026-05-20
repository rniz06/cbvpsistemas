<div>
    {{-- Formulario --}}
    <x-adminlte-card theme="light" title="Agregar Item" icon="fas fa-plus-circle" header-class="text-muted text-sm">
        <form class="col-md-12 row" wire:submit="guardar">

            {{-- Categorias --}}
            <x-adminlte-select name="categoria_id" wire:model.blur="categoria_id" label-class="text-lightblue"
                fgroup-class="col-md-3">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Categoria *</div>
                </x-slot>
                <option value="">Seleccionar</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id_menor_categoria }}">{{ $categoria->nombre ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Componentes --}}
            <x-adminlte-select name="componente_id" wire:model.blur="componente_id" label-class="text-lightblue"
                fgroup-class="col-md-3">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Componentes *</div>
                </x-slot>
                <option value="">Seleccionar</option>
                @foreach ($componentes as $componente)
                    <option value="{{ $componente->id_menor_componente }}">
                        {{ $componente->nombre ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

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
