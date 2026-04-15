<div>
    {{-- Formulario --}}
    <x-adminlte-card theme="light" title="Agregar Equipo Forestal" icon="fas fa-plus-circle" header-class="text-muted text-sm">
        <form class="col-md-12 row" wire:submit="guardar">

            {{-- COMPONENTE --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Item:</div>
                        </div>
                        <select class="form-control @error('componente_id') is-invalid @enderror"
                            id="componente_id" name="componente_id"
                            wire:model.blur="componente_id">
                            <option value="">-- Seleccionar --</option>
                            @foreach ($this->componentes as $componente)
                                <option value="{{ $componente->id_menor_componente }}">
                                    {{ $componente->nombre ?? 'S/D' }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('componente_id')
                        <div class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </div>

            {{-- CANTIDAD OPERATIVO --}}
            <x-adminlte-input name="cantidad_operativo" wire:model.blur="cantidad_operativo" type="number" placeholder="EJ: 0"
                label-class="text-lightblue" fgroup-class="col-md-3" >
                <x-slot name="prependSlot">
                    <div class="input-group-text">Cant. Operativo *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- CANTIDAD INOPERATIVO --}}
            <x-adminlte-input name="cantidad_inoperativo" wire:model.blur="cantidad_inoperativo" type="number" placeholder="EJ: 0"
                label-class="text-lightblue" fgroup-class="col-md-3" >
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
