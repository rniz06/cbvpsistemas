<form wire:submit.prevent="guardar" class="row">

        {{-- Nombre --}}
        <x-adminlte-input name="nombre" wire:model.blur="nombre" oninput="this.value = this.value.toUpperCase()"
            placeholder="NOMBRE..." label-class="text-lightblue" fgroup-class="col-md-4">
            <x-slot name="prependSlot">
                <div class="input-group-text">Nombre *</div>
            </x-slot>
        </x-adminlte-input>

    {{-- TIPOS --}}
    <x-adminlte-select name="tipo_id" wire:model.blur="tipo_id" label-class="text-lightblue" fgroup-class="col-md-4">
            <x-slot name="prependSlot">
                <div class="input-group-text">Componente de *</div>
            </x-slot>
            <option value="">-- Seleccionar --</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id_menor_tipo }}">
                            {{ $tipo->tipo ?? 'S/D' }}</option>
                    @endforeach
        </x-adminlte-select>
    {{-- <div class="col-md-4">
        <div class="form-group">
            <div class="input-group mb-2" wire:ignore>
                <div class="input-group-prepend">
                    <div class="input-group-text">Componentes de:</div>
                </div>
                <select class="form-control @error('tipo_id') is-invalid @enderror" id="buscarTipoId"
                    name="tipo_id" wire:model.live.debounce.200ms="tipo_id">
                    <option value="">-- Seleccionar --</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id_menor_tipo }}">
                            {{ $tipo->tipo ?? 'S/D' }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div> --}}

    {{-- CATEGORIAS --}}
    <div class="col-md-4">
        <div class="form-group">
            <div class="input-group mb-2" wire:ignore>
                <div class="input-group-prepend">
                    <div class="input-group-text">Categorias:</div>
                </div>
                <select class="form-control @error('categoria_id') is-invalid @enderror" id="buscarCategoriaId"
                    name="categoria_id" wire:model.live.debounce.200ms="categoria_id">
                    <option value="">-- Seleccionar --</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id_menor_categoria }}">
                            {{ $categoria->nombre ?? 'S/D' }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <x-adminlte-button type="submit" theme="outline-success" icon="fas fa-save" class="btn-sm"
            label="Guardar cambios" />
        <x-adminlte-button theme="outline-secondary" label="Cerrar" icon="fas fa-window-close" class="btn-sm"
            data-dismiss="modal" wire:click="resetForm" />
    </div>
</form>
