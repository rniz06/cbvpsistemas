<div>
    {{-- Tabla de Voluntarios --}}
    <x-table.table titulo="Listado De Voluntarios" ocultarBuscador>

        <x-slot name="cabeceras">

            {{-- Nombre Completo --}}
            <th>
                <div>
                    <x-adminlte-input name="buscarNombreCompleto" label="Nombre Completo:" fgroup-class="col-md-12"
                        igroup-size="sm" wire:model.live.debounce.250ms="buscarNombreCompleto"
                        oninput="this.value = this.value.toUpperCase()" />
                </div>
            </th>

            {{-- Código --}}
            <th>
                <div>
                    <x-adminlte-input type="number" name="buscarCodigo" label="Código:" fgroup-class="col-md-12"
                        wire:model.live.debounce.250ms="buscarCodigo" igroup-size="sm" />
                </div>
            </th>

            {{-- Práctica --}}
            <th>
                <div>
                    <x-adminlte-input name="" label="Práctica:" fgroup-class="col-md-12" igroup-size="sm"
                        readonly />
                </div>
            </th>

            {{-- Guardia --}}
            <th>
                <div>
                    <x-adminlte-input name="" label="Guardia:" fgroup-class="col-md-12" igroup-size="sm"
                        readonly />
                </div>
            </th>

            {{-- Citación --}}
            <th>
                <div>
                    <x-adminlte-input name="" label="Citación:" fgroup-class="col-md-12" igroup-size="sm"
                        readonly />
                </div>
            </th>

            {{-- Acciones --}}
            <th>
                <div>
                    <x-adminlte-input name="" label="Acciones:" fgroup-class="col-md-12" igroup-size="sm"
                        readonly />
                </div>
            </th>

        </x-slot>
        @forelse ($voluntarios as $personal)
            <tr wire:key="fila-{{ $personal->id_asistencia_detalle }}">
                <td>{{ $personal->personal->nombrecompleto ?? 'S/D' }}</td>
                <td>{{ $personal->personal->codigo ?? 'S/D' }}</td>

                <td>
                    <span class="badge {{ $personal->practica !== null ? 'badge-success' : 'badge-danger' }}">
                        {{ $personal->practica ?? 'S/D' }}
                    </span>
                </td>

                <td>
                    <span class="badge {{ $personal->guardia !== null ? 'badge-success' : 'badge-danger' }}">
                        {{ $personal->guardia ?? 'S/D' }}
                    </span>
                </td>

                <td><span class="badge {{ $personal->citacion !== null ? 'badge-success' : 'badge-danger' }}">
                        {{ $personal->citacion ?? 'S/D' }}
                    </span></td>

                <td>
                    <div class="d-inline-flex align-items-center gap-2">
                        {{-- Boton --}}
                        <x-adminlte-button label="Cargar" data-toggle="modal" icon="fas fa-pencil-alt"
                            theme="outline-success" class="btn-sm"
                            data-target="#cargar-asistencia-{{ $personal->id_asistencia_detalle }}" />
                        @livewire('personal.asistencias.carga', ['asistencia_detalle_id' => $personal->id_asistencia_detalle], key($personal->id_asistencia_detalle))

                        @if ($personal->personal->estado_actualizar_id == 1)
                            <a href="{{ route('personal.edit', $personal->personal_id) }}"
                                class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i> Act. Ficha Vol.</a>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
            </tr>
        @endforelse
        <x-slot name="paginacion">
            {{ $voluntarios->links() }}
        </x-slot>
    </x-table.table>
</div>
