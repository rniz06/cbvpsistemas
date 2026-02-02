<div>
    {{-- Info del usuario --}}
    <h4>Información del Usuario:</h4>
    <div class="col-md-12 row">
        <x-adminlte-callout theme="success" title="Roles" class="col-md-6">
            @forelse ($roles as $role)
                {{ $role ? ucwords(str_replace('_', ' ', $role . ' - ')) : 'S/D' }}
            @empty
                <p class="font-italic">Sin roles...</p>
            @endforelse
        </x-adminlte-callout>
        <x-adminlte-callout theme="success" title="Asignado a" class="col-md-6">
            {{ $companiaAsignada->compania ?? 'S/D' }}
        </x-adminlte-callout>
    </div>
    <x-adminlte-callout theme="success">
        <div class="col-md-12 row">
            {{-- Minimal --}}
            <x-adminlte-input name="" label="Nombre Completo:" value="{{ $usuario->nombrecompleto }}"
                fgroup-class="col-md-3" disabled />

            <x-adminlte-input name="" label="Codigo:" value="{{ $usuario->codigo }}" fgroup-class="col-md-3"
                disabled />

            <x-adminlte-input name="" label="Categoria:" value="{{ $usuario->categoria }}"
                fgroup-class="col-md-3" disabled />

            <x-adminlte-input name="" label="Compañia:" value="{{ $usuario->compania }}" fgroup-class="col-md-3"
                disabled />
        </div>
        <form wire:submit.prevent="guardar">
            <div class="col-md-12">
                <label for="">Roles:</label>
                <select name="roles" class="form-control" wire:model.live="roles" multiple size="5">
                    @foreach ($rolesSelect as $rol)
                        <option value="{{ $rol }}">{{ $rol }}</option>
                    @endforeach
                </select>
            </div>
            <br>
            @if ($this->debeMostrarSelectCompania)
                <div class="col-md-4">
                    <x-adminlte-select name="compania_id" wire:model.live="compania_id" label="Compañía:">
                        <option value="">-- Seleccionar --</option>
                        @foreach ($companias as $compania)
                            <option value="{{ $compania->id_compania }}">{{ $compania->compania ?? 'S/D' }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            @endif
            <x-adminlte-button type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save" />
        </form>
    </x-adminlte-callout>
</div>

@push('scripts')
@endpush

@push('css')
@endpush
