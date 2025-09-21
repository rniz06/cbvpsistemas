<div>
    <!-- Tabla -->
    <x-tabla titulo="Listado de Conductores" excel pdf>
        <x-slot name="headerBotones">
            @can('Conductores Crear')
                <a href="{{ route('materiales.conductores.create') }}" class="btn btn-sm btn-success"><i
                        class="fas fa-plus"></i> Agregar
                    Conductor</a>
            @endcan
        </x-slot>

        <x-slot name="cabeceras">
            <th><x-adminlte-input name="" wire:model.live.debounce.150ms="buscarCodigo" label="Codigo:" /></th>
            <th><x-adminlte-input name="" wire:model.live.debounce.150ms="buscarNombrecompleto"
                    label="Nombre Completo:" /></th>
            <th><x-adminlte-select name="" wire:model.live.debounce.150ms="buscarCompaniaId" label="Compañia:">
                    <option value="">-- TODOS --</option>
                    @foreach ($companias as $compania)
                        <option value="{{ $compania->id_compania }}">{{ $compania->compania ?? 'S/D' }}</option>
                    @endforeach
                </x-adminlte-select>
            </th>
            <th><x-adminlte-select name="" wire:model.live.debounce.150ms="buscarEstadoId" label="Estado:">
                    <option value="">-- TODOS --</option>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id_conductor_estado }}">{{ $estado->estado ?? 'S/D' }}</option>
                    @endforeach
                </x-adminlte-select>
            </th>
            <th><x-adminlte-select name="" wire:model.live.debounce.150ms="buscarClaseLicenciaId"
                    label="Clase Licencia:">
                    <option value="">-- TODOS --</option>
                    @foreach ($licencias as $licencia)
                        <option value="{{ $licencia->idconductor_clase_licencia }}">{{ $licencia->clase ?? 'S/D' }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </th>
            <th>Acciones:</th>
        </x-slot>

        @forelse ($conductores as $conductor)
            <tr>
                <td>{{ $conductor->codigo ?? 'S/D' }}</td>
                <td>{{ $conductor->nombrecompleto ?? 'S/D' }}</td>
                <td>{{ $conductor->compania ?? 'S/D' }}</td>
                <td>{{ $conductor->estado ?? 'S/D' }}</td>
                <td>{{ $conductor->clase_licencia ?? 'S/D' }}</td>
                <td>
                    @can('Conductores Ver')
                        <a href="{{ route('materiales.conductores.show', $conductor->id_conductor_bombero) }}"
                            class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Ver Ficha</a>
                    @endcan
                    @can('Conductores Editar')
                        <a href="{{ route('materiales.conductores.edit', $conductor->id_conductor_bombero) }}"
                            class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Actualizar</a>
                    @endcan
                </td>
            </tr>
        @empty
            <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
        @endforelse
        <x-slot name="paginacion">
            {{ $conductores->links() }}
        </x-slot>
    </x-tabla>

</div>

@push('scripts')
@endpush

@push('css')
@endpush
