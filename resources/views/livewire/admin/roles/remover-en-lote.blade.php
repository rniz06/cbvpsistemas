<div>
    {{-- Formulario --}}
    <x-adminlte-card theme="light" title="Remover rol de Usuarios" icon="fas fa-user-times" header-class="text-muted text-sm">
        <form class="col-md-12 p-2 row" wire:submit="guardar">

            {{-- Roles --}}
            <x-adminlte-select name="role_id" wire:model.blur="role_id" label-class="text-lightblue"
                fgroup-class="col-md-3" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Rol a remover *</div>
                </x-slot>
                <option value="">Seleccionar</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Botón de Volver --}}
            <div class="form-group col-xl-3 d-flex align-items-end">
                <a href="{{ url()->previous() }}"
                    class="btn btn-block btn-outline-secondary text-decoration-none btn-sm"><i
                        class="fas fa-arrow-left mr-1"></i>Volver</a>
            </div>

            {{-- Botón de Guardar --}}
            <div class="form-group col-xl-3 d-flex align-items-end">
                <x-adminlte-button type="submit" label="Guardar" theme="outline-success" icon="fas fa-lg fa-save"
                    class="w-100 btn-sm" />
            </div>
        </form>
    </x-adminlte-card>
</div>