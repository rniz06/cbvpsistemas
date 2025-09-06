<div>
    <!-- Tabla -->
    <x-tabla titulo="Listado de Cargos - CBVP" excel pdf>
        <x-slot name="cabeceras">
            <th>
                <div>
                    <x-adminlte-input name="buscarCargo" label="Cargo:" placeholder="Cargo..." fgroup-class="col-md-12"
                        wire:model.live.debounce.250ms="buscarCargo" oninput="this.value = this.value.toUpperCase()" />
                </div>
            </th>
            <th>
                <div>
                    <x-adminlte-select name="buscarRangoId" label="Rango:" wire:model.live.debounce.250ms="buscarRangoId"
                        fgroup-class="col-md-12">
                        <option value="">-- Todos --</option>
                        @foreach ($rangos as $rango)
                            <option value="{{ $rango->id_rango }}">
                                {{ $rango->rango ?? 'S/D' }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            </th>
        </x-slot>

        @forelse ($cargos as $cargo)
            <tr wire:click="seleccionado({{ $cargo->id_cargo }})" wire:key="{{ $cargo->id_cargo }}">
                <td>{{ $cargo->cargo ?? 'S/D' }}</td>
                <td>{{ $cargo->rango ?? 'S/D' }}</td>
            </tr>
        @empty
            <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
        @endforelse

        <x-slot name="paginacion">
            {{ $cargos->links() }}
        </x-slot>
    </x-tabla>
    <p class="font-weight-bold">Obs: Cualquier Cambio en los parametros de los cargos puede afectar a la generación automatica del Código de Comisionamiento en el módulo de Comisionamientos.</p>

</div>
