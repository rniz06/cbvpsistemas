<div>
    <x-adminlte-card theme="light" title="Parametros de Filtrado" icon="fas fa-filter"
        header-class="text-muted text-sm">
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
            <x-adminlte-select name="acronimo_id" wire:model.live.debounce.200ms="acronimo_id" label-class="text-lightblue"
                fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Acrónimos</div>
                </x-slot>
                <option value="">-- Todos --</option>
                @foreach ($acronimos as $acronimo)
                    <option value="{{ $acronimo->id_movil_tipo }}">{{ $acronimo->tipo ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Marcas --}}
            <x-adminlte-select name="marca_id" wire:model.live.debounce.200ms="marca_id" label-class="text-lightblue"
                fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Marcas</div>
                </x-slot>
                <option value="">-- Todos --</option>
                @foreach ($marcas as $marca)
                    <option value="{{ $marca->id_movil_marca }}">{{ $marca->marca ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Modelos --}}
            <x-adminlte-select name="modelo_id" wire:model.live.debounce.200ms="modelo_id" label-class="text-lightblue"
                fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Modelos</div>
                </x-slot>
                <option value="">-- Todos --</option>
                @foreach ($modelos as $modelo)
                    <option value="{{ $modelo->id_movil_modelos }}">{{ $modelo->modelo ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Operatividad --}}
            <x-adminlte-select name="operatividad_id" wire:model.live.debounce.200ms="operatividad_id" label-class="text-lightblue"
                fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Operatividad</div>
                </x-slot>
                <option value="">-- Todos --</option>
                @foreach ($operatividad as $operatividad)
                    <option value="{{ $operatividad->id_operatividad }}">{{ $operatividad->operatividad ?? 'S/D' }}
                    </option>
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

            {{-- Transmisiones --}}
            <x-adminlte-select name="transmision_id" wire:model.live.debounce.200ms="transmision_id" label-class="text-lightblue"
                fgroup-class="col-md-3" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Transmisiones</div>
                </x-slot>
                <option value="">-- Todos --</option>
                @foreach ($transmisiones as $transmision)
                    <option value="{{ $transmision->id_movil_transmision }}">{{ $transmision->transmision ?? 'S/D' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Ejes --}}
            <x-adminlte-select name="eje_id" wire:model.live.debounce.200ms="eje_id" label-class="text-lightblue"
                fgroup-class="col-md-3" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Ejes</div>
                </x-slot>
                <option value="">-- Todos --</option>
                @foreach ($ejes as $eje)
                    <option value="{{ $eje->id_movil_eje }}">{{ $eje->eje ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Combustibles --}}
            <x-adminlte-select name="eje_id" wire:model.live.debounce.200ms="eje_id" label-class="text-lightblue"
                fgroup-class="col-md-3" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Combustibles</div>
                </x-slot>
                <option value="">-- Todos --</option>
                @foreach ($combustibles as $combustible)
                    <option value="{{ $eje->id_movil_combustible }}">{{ $combustible->tipo ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

        </form>
    </x-adminlte-card>

    <!-- Tabla -->
    <x-table.table titulo="Reporte" ocultarBuscador excel pdf>
        <x-slot name="cabeceras">
            <th>Móvil</th>
            <th>Compañía</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Transmisión</th>
            <th>Eje</th>
            <th>Combustible</th>
            <th>Operatividad</th>
            <th>Año</th>
            <th>Chapa</th>
            <th>C. delanteras</th>
            <th>C. traseras</th>
        </x-slot>

        @forelse ($resultados as $resultado)
            <tr wire:key="{{ $resultado->id_movil }}">
                <td>{{ $resultado->movil ?? 'S/D' }}</td>
                <td>{{ $resultado->compania ?? 'S/D' }}</td>
                <td>{{ $resultado->marca ?? 'S/D' }}</td>
                <td>{{ $resultado->modelo ?? 'S/D' }}</td>
                <td>{{ $resultado->transmision ?? 'S/D' }}</td>
                <td>{{ $resultado->eje ?? 'S/D' }}</td>
                <td>{{ $resultado->combustible ?? 'S/D' }}</td>
                <td>{{ $resultado->operatividad ?? 'S/D' }}</td>
                <td>{{ $resultado->anho ?? 'S/D' }}</td>
                <td>{{ $resultado->chapa ?? 'S/D' }}</td>
                <td>{{ $resultado->cubiertas_frente ?? 'S/D' }}</td>
                <td>{{ $resultado->cubiertas_atras ?? 'S/D' }}</td>
            </tr>
        @empty
            <td colspan="100%" class="text-center text-muted">Sin resultados...</td>
        @endforelse

        <x-slot name="paginacion">
            {{ $resultados->links() }}
        </x-slot>
    </x-table.table>
</div>
