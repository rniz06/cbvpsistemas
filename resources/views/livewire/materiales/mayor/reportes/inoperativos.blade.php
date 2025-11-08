<div>
    <x-adminlte-card theme="light" title="Parametros de Filtrado" icon="fas fa-filter" header-class="text-muted text-sm">
        <form class="row col-md-12">

            {{-- Compañías --}}
            <x-adminlte-select name="compania_id" wire:model.live.debounce.200ms="compania_id" label-class="text-lightblue"
                fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Compañías</div>
                </x-slot>
                <option value="">-- Todos --</option>
                @foreach ($companias as $compania)
                    <option value="{{ $compania->id_compania }}">{{ $compania->compania ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Acrónimo --}}
            <x-adminlte-select name="acronimo_id" wire:model.live.debounce.200ms="acronimo_id"
                label-class="text-lightblue" fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Acrónimos</div>
                </x-slot>
                <option value="">-- Todos --</option>
                @foreach ($acronimos as $acronimo)
                    <option value="{{ $acronimo->id_movil_tipo }}">{{ $acronimo->tipo ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Años --}}
            <x-adminlte-select name="anho_id" wire:model.live.debounce.200ms="anho_id" label-class="text-lightblue"
                fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Años</div>
                </x-slot>
                <option value="">-- Todos --</option>
                @foreach ($anhos as $anhos)
                    <option value="{{ $anhos }}">{{ $anhos ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Motivos --}}
            <x-adminlte-select name="accion_categoria_id" wire:model.live.debounce.200ms="accion_categoria_id"
                label-class="text-lightblue" fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Motivos</div>
                </x-slot>
                <option value="">-- Todos --</option>
                @foreach ($motivos as $motivo)
                    <option value="{{ $motivo->id_accion_categoria }}">{{ $motivo->categoria ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Motivos Detalles --}}
            <x-adminlte-select name="categoria_detalle_id" wire:model.live.debounce.200ms="categoria_detalle_id"
                label-class="text-lightblue" fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Motivos Detalles</div>
                </x-slot>
                <option value="">-- Todos --</option>
                @foreach ($detalles as $detalle)
                    <option value="{{ $detalle->idaccion_categoria_detalle }}">{{ $detalle->detalle ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

        </form>
    </x-adminlte-card>

    <!-- Tabla -->
    <x-table.table titulo="Listado de Moviles Inoperativos" ocultarBuscador excel>
        <x-slot name="cabeceras">
            <th>Móvil</th>
            <th>Compañía</th>
            <th>Año</th>
            <th>Motivo</th>
            <th>Detalle</th>
            <th></th>
        </x-slot>

        @forelse ($inoperativos as $resultado)
            <tr wire:key="{{ $resultado->id_movil }}">
                <td>{{ $resultado->acronimo->tipo ?? 'S/D' }}-{{ $resultado->movil ?? 'S/D' }}</td>
                <td>{{ $resultado->compania->compania ?? 'S/D' }}</td>
                <td>{{ $resultado->anho ?? 'S/D' }}</td>
                <td>{{ $resultado->ultimoComentarioFueraServicio?->motivo?->categoria ?? 'S/D' }}</td>
                <td>{{ $resultado->ultimoComentarioFueraServicio?->detalle?->detalle ?? 'S/D' }}</td>
                {{-- ultimoComentarioFueraServicio --}}
                <td><a href="{{ route('materiales.mayor.show', $resultado->id_movil) }}"
                        class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a></td>
            </tr>
        @empty
            <td colspan="100%" class="text-center text-muted">Sin resultados...</td>
        @endforelse

        <x-slot name="paginacion">
            {{ $inoperativos->links() }}
        </x-slot>
    </x-table.table>
</div>
