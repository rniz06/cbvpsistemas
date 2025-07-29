<div>
    {{-- Tabla de Comisionamientos --}}
    <x-table.table titulo="Listado De Comisionamientos" ocultarBuscador excel pdf>

        <x-slot name="headerBotones">
            <a href="{{ route('personal.comisionamientos.create') }}" class="btn btn-sm btn-success"><i
                    class="fas fa-plus mr-1"></i> Agregar</a>
        </x-slot>

        <x-slot name="cabeceras">

            {{-- Nombre Completo --}}
            <th>
                <div>
                    <x-adminlte-input name="buscarNombreCompleto" label="Nombre Completo:" fgroup-class="col-md-12"
                        wire:model.live.debounce.250ms="buscarNombreCompleto"
                        oninput="this.value = this.value.toUpperCase()" />
                </div>
            </th>

            {{-- Código --}}
            <th>
                <div>
                    <x-adminlte-input type="number" name="buscarCodigo" label="Código:" fgroup-class="col-md-12"
                        wire:model.live.debounce.250ms="buscarCodigo" />
                </div>
            </th>

            {{-- Comisionado a --}}
            <th>
                <div>
                    <x-adminlte-select name="buscarCompaniaId" label="Comisionado a:"
                        wire:model.live.debounce.250ms="buscarCompaniaId" fgroup-class="col-md-12">
                        <option value="">-- Todos --</option>
                        @forelse ($companias as $compania)
                            <option value="{{ $compania->id_compania ?? 'S/D' }}">
                                {{ $compania->compania ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>
            </th>

            {{-- Fecha Inicio --}}
            <th>
                <div>
                    <x-adminlte-input type="date" name="buscarFechaInicio" label="Fecha Inicio:"
                        fgroup-class="col-md-12" wire:model.live.debounce.250ms="buscarFechaInicio" />
                </div>
            </th>

            {{-- Fecha Fin --}}
            <th>
                <div>
                    <x-adminlte-input type="date" name="buscarFechaFin" label="Fecha Fin:" fgroup-class="col-md-12"
                        wire:model.live.debounce.250ms="buscarFechaFin" />
                </div>
            </th>

            {{-- Código Comisionamiento --}}
            <th>
                <div>
                    <x-adminlte-input name="buscarCodigoComisionamiento" label="Cód. Comisionamiento:"
                        oninput="this.value = this.value.toUpperCase()" fgroup-class="col-md-12"
                        wire:model.live.debounce.250ms="buscarCodigoComisionamiento" />
                </div>
            </th>

            {{-- Culminado --}}
            <th>
                <div>
                    <x-adminlte-select name="buscarCulminados" label="Culminado:"
                        wire:model.live.debounce.250ms="buscarCulminado" fgroup-class="col-md-12">
                        <option value="">-- Todos --</option>
                        <option value="1">Si</option>
                        <option value="0">No</option>
                        <option value="null">Indefinido</option>
                    </x-adminlte-select>
                </div>
            </th>

            <th>Acciones:</th>

        </x-slot>
        @forelse ($comisionamientos as $comisionamiento)
            <tr>
                <td>{{ $comisionamiento->nombrecompleto ?? 'N/A' }}</td>
                <td>{{ $comisionamiento->codigo ?? 'N/A' }}</td>
                <td>{{ $comisionamiento->compania ?? 'N/A' }}</td>
                <td>{{ $comisionamiento->fecha_inicio ? $comisionamiento->fecha_inicio->format('d / m / Y') : 'S/D' }}
                </td>
                <td>{{ $comisionamiento->fecha_fin ? $comisionamiento->fecha_fin->format('d / m / Y') : 'S/D' }}</td>
                <td>{{ $comisionamiento->codigo_comisionamiento ?? 'N/A' }}</td>
                <td>
                    <span
                        class="badge 
        {{ is_null($comisionamiento->culminado) ? 'badge-danger' : ($comisionamiento->culminado ? 'badge-success' : 'badge-warning') }}">
                        {{ is_null($comisionamiento->culminado) ? 'INDEFINIDO' : ($comisionamiento->culminado ? 'SI' : 'NO') }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('personal.comisionamientos.edit', $comisionamiento->id_comisionamiento) }}"
                        class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i> Editar</a>
                    @if ($comisionamiento->culminado != 1)
                        <x-adminlte-button class="btn-sm" label="Culminar" theme="outline-danger"
                            wire:click="culminar"
                            wire:confirm="Estas Seguro de Culminar este Comisionamiento?" />
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
            </tr>
        @endforelse
        <x-slot name="paginacion">
            {{ $comisionamientos->links() }}
        </x-slot>
    </x-table.table>
</div>
