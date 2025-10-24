<div>
    {{-- Tabla de Personales --}}
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
        @forelse ($personales as $personal)
            <tr wire:key="fila-{{ $personal->id_asistencia_detalle }}">
                <td>{{ $personal->personal->nombrecompleto ?? 'S/D' }}</td>
                <td>{{ $personal->personal->codigo ?? 'S/D' }}</td>
                <td>
                    <x-adminlte-input type="number" name="practica_{{ $personal->id_asistencia_detalle }}"
                        wire:model.blur="practica.{{ $personal->id_asistencia_detalle }}" igroup-size="sm" />
                </td>
                <td>
                    <x-adminlte-input type="number" name="guardia_{{ $personal->id_asistencia_detalle }}"
                        wire:model.blur="guardia.{{ $personal->id_asistencia_detalle }}" igroup-size="sm" />
                </td>
                <td>
                    <x-adminlte-input type="number" name="citacion_{{ $personal->id_asistencia_detalle }}"
                        wire:model.blur="citacion.{{ $personal->id_asistencia_detalle }}" igroup-size="sm" />
                </td>
                <td>
                    <x-adminlte-button wire:click="grabar({{ $personal->id_asistencia_detalle }})" class="btn-sm"
                        label="Guardar" icon="fas fa-sm fa-save" theme="outline-success" />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
            </tr>
        @endforelse
        <x-slot name="paginacion">
            {{ $personales->links() }}
        </x-slot>
    </x-table.table>
</div>
