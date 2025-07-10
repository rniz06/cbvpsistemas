<div>
    <!-- Tabla -->
    <x-tabla titulo="Despacho por compañia">
        <x-slot name="cabeceras">
            <th>
                <div>
                    <x-adminlte-input name="buscarCompania" label="Compañia:" placeholder="Compañia..."
                        fgroup-class="col-md-12" wire:model.live.debounce.250ms="buscarCompania"
                        oninput="this.value = this.value.toUpperCase()" />
                </div>
            </th>
            <th>
                <div>
                    <x-adminlte-select name="buscarDepartamentoId" label="Departamento:"
                        wire:model.live.debounce.250ms="buscarDepartamentoId" fgroup-class="col-md-12">
                        <option value="">-- Todos --</option>
                        @forelse ($departamentos as $departamento)
                            <option value="{{ $departamento->id_departamento ?? 'S/D' }}">
                                {{ $departamento->departamento ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>
            </th>
            <th>
                <div>
                    <x-adminlte-select name="buscarCiudadId" label="Ciudad:"
                        wire:model.live.debounce.250ms="buscarCiudadId" fgroup-class="col-md-12">
                        <option value="">-- Todos --</option>
                        @forelse ($ciudades as $ciudad)
                            <option value="{{ $ciudad->id_ciudad ?? 'S/D' }}">{{ $ciudad->ciudad ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>
            </th>
            <th>
                <div>
                    <x-adminlte-select name="buscarRegionId" label="Región:"
                        wire:model.live.debounce.250ms="buscarRegionId" fgroup-class="col-md-12">
                        <option value="">-- Todos --</option>
                        @forelse ($regiones as $region)
                            <option value="{{ $region->id_region ?? 'S/D' }}">{{ $region->region ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>
            </th>
            <th></th>
        </x-slot>

        @forelse ($companias as $compania)
            <tr>
                <td>{{ $compania->compania ?? 'S/D' }}</td>
                <td>{{ $compania->departamento ?? 'S/D' }}</td>
                <td>{{ $compania->ciudad ?? 'S/D' }}</td>
                <td>{{ $compania->region ?? 'S/D' }}</td>
                <td><a href="{{ route('cca.despacho.despacho-por-compania-final', $compania->id_compania) }}" class="btn btn-sm btn-danger">Despachar</a></td>
            </tr>
        @empty
            <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
        @endforelse

        <x-slot name="paginacion">
            {{ $companias->links() }}
        </x-slot>
    </x-tabla>
</div>
