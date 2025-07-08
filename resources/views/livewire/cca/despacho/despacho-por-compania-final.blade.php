<div>
    <h4>Despacho por compañia - {{ $compania->compania ?? 'S/D' }} - {{ $compania->departamento ?? 'S/D' }} -
        {{ $compania->ciudad ?? 'S/D' }}</h4>

    {{-- Formulario --}}
    <x-adminlte-card theme="success" theme-mode="outline">
        <form class="col-md-12 row" wire:submit="grabar">
            {{-- Compania --}}
            <x-adminlte-input name="compania" label="Compañia:" placeholder="Compañia..." fgroup-class="col-md-3"
                oninput="this.value = this.value.toUpperCase()" wire:model.blur="compania" />
            {{-- Ciudad --}}
            <div class="col-md-3">
                <x-adminlte-select name="ciudad_id" label="Ciudad:" wire:model.blur="ciudad_id" >
                    <option>-- Seleccionar --</option>
                    @forelse ($ciudades as $ciudad)
                        <option value="{{ $ciudad->id_ciudad ?? 'S/D' }}">{{ $ciudad->ciudad ?? 'S/D' }}</option>
                    @empty
                        <option>Sin datos...</option>
                    @endforelse
                </x-adminlte-select>
            </div>
            {{-- Region --}}
            <div class="col-md-3">
                <x-adminlte-select name="region_id" label="Región:" wire:model.blur="region_id">
                    <option>-- Seleccionar --</option>
                    @forelse ($regiones as $region)
                        <option value="{{ $region->id_region ?? 'S/D' }}">{{ $region->region ?? 'S/D' }}</option>
                    @empty
                        <option>Sin datos...</option>
                    @endforelse
                </x-adminlte-select>
            </div>
            {{-- Orden --}}
            <x-adminlte-input type="number" name="orden" label="Orden:" placeholder="Orden..."
                fgroup-class="col-md-3" wire:model.blur="orden" />

            {{-- Botones --}}
            <div class="card-footer">
                @can('Companias Crear')
                    <x-adminlte-button type="button" label="Agregar" theme="success" icon="fas fa-lg fa-plus"
                        wire:click="agregar" />
                @endcan
                @can('Companias Editar')
                    <x-adminlte-button type="button" label="Modificar" theme="warning" icon="fas fa-lg fa-edit"
                        wire:click="editar" />
                @endcan
                @can('Companias Eliminar')
                    <x-adminlte-button type="button" label="Eliminar" theme="danger" icon="fas fa-lg fa-trash"
                        id="btn-eliminar" />
                @endcan
                @canany(['Companias Crear', 'Companias Editar'])
                    <x-adminlte-button type="button" label="Grabar" theme="default" icon="fas fa-lg fa-save"
                        id="btn-grabar" />
                @endcanany


                <x-adminlte-button type="button" label="Cancelar" theme="secondary" icon="fas fa-lg fa-window-close"
                    wire:click="cancelar" />
            </div>
        </form>
    </x-adminlte-card>
</div>
