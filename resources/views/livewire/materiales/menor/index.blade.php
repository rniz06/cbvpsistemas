<div>
    <div class="row col-md-12">
        <div class="col-md-6">
            <x-table.tabla titulo="Material Menor">

                <x-slot name="encabezados">
                    <th>#</th>
                    <th>Item</th>
                    <th>Categoria</th>
                    <th>Cant. Operativos</th>
                    <th>Cant. Inoperativos</th>
                    <th>Compañia</th>
                    <th>Acciones</th>
                </x-slot>

                @forelse ($menor as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <th>{{ $item->componente->nombre ?? 'S/D' }}</th>
                        <th>{{ $item->componente->categoria->nombre ?? 'S/D' }}</th>
                        <th>{{ $item->cantidad_operativo ?? 'S/D' }}</th>
                        <th>{{ $item->cantidad_inoperativo ?? 'S/D' }}</th>
                        <th>{{ $item->compania->compania ?? 'S/D' }}</th>
                        <th>
                            <x-tabla-dropdown>
                                <x-adminlte-button label="Ver Movimientos" icon="fas fa-eye" class="dropdown-item btn-sm"
                                    data-toggle="modal" data-target="#modal-ver-movimientos" />

                                <x-adminlte-button label="Actualizar" icon="fas fa-edit" class="dropdown-item btn-sm"
                                    data-toggle="modal" data-target="#modal-ver-movimientos" />
                            </x-tabla-dropdown>

                        </th>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                        </td>
                    </tr>
                @endforelse

                <x-slot name="paginacion">
                    {{ $menor->links() }}
                </x-slot>

            </x-table.tabla>
            <br>
            @foreach ($menor as $item)
                {{ $item ?? 'S/D' }}
            @endforeach
        </div>

        {{-- EQUIPOS FORESTALES --}}
        <div class="col-md-6">
            <x-table.tabla titulo="Equipos Forestales">

                <x-slot name="encabezados">
                    <th>#</th>
                    <th>Item</th>
                    <th>Cant. Operativos</th>
                    <th>Cant. Inoperativos</th>
                    <th>Compañia</th>
                    <th>Acciones</th>
                </x-slot>

                @forelse ($forestales as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <th>{{ $item->componente->nombre ?? 'S/D' }}</th>
                        <th>{{ $item->cantidad_operativo ?? 'S/D' }}</th>
                        <th>{{ $item->cantidad_inoperativo ?? 'S/D' }}</th>
                        <th>{{ $item->compania->compania ?? 'S/D' }}</th>
                        <th>
                            <x-tabla-dropdown>
                                <x-adminlte-button label="Ver Movimientos" icon="fas fa-eye"
                                    class="dropdown-item btn-sm" data-toggle="modal"
                                    data-target="#modal-ver-movimientos" />

                                <x-adminlte-button label="Actualizar" icon="fas fa-edit" class="dropdown-item btn-sm"
                                    data-toggle="modal" data-target="#modal-ver-movimientos" />
                            </x-tabla-dropdown>

                        </th>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                        </td>
                    </tr>
                @endforelse

                <x-slot name="paginacion">
                    {{ $forestales->links() }}
                </x-slot>

            </x-table.tabla>
            <br>
            @foreach ($forestales as $item)
                {{ $item ?? 'S/D' }}
            @endforeach
        </div>
    </div>
</div>
