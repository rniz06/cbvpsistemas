<div>
    <x-table.tabla titulo="Lista de Marcas - Mat. Menor" pdf="pdf" excel="excel" dropdown_direccion="dropleft">

        @can('Materiales Menor Marcas Crear')
            <x-slot name="acciones">
                <x-adminlte-button label="Añadir Marca" class="btn-sm dropdown-item" icon="fas fa-plus" data-toggle="modal"
                    data-target="#modal-create-marca" /> </x-slot>
            @livewire('materiales.menor.marcas.modal-create')
        @endcan

        <x-slot name="encabezados">
            {{-- Numero en la fila --}}
            <th style="width: 10px">N°</th>

            {{-- Nombre --}}
            <th>Nombre</th>

            {{-- Acciones --}}
            <th>Acciones</th>

        </x-slot>

        @forelse ($marcas as $index => $marca)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $marca->nombre ?? 'S/D' }}</td>
                <td>
                    <x-tabla-dropdown>

                        {{-- EDITAR --}}
                        @can('Materiales Menor Marcas Editar')
                            <a href="#" class="btn dropdown-item btn-sm"><i class="fas fa-edit"></i>
                                Editar</a>
                        @endcan

                        {{-- LINEA DIVISORIA --}}
                        <div class="dropdown-divider"></div>

                        {{-- ELIMINAR --}}
                        @can('Materiales Menor Marcas Eliminar')
                            {{-- @livewire('admin.usuarios.eliminar', ['usuario_id' => $usuario->id_usuario], key($usuario->id_usuario)) --}}
                            <a href="#" class="btn dropdown-item btn-sm"><i class="fas fa-trash"></i>
                                Eliminar</a>
                        @endcan
                    </x-tabla-dropdown>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                </td>
            </tr>
        @endforelse

        <x-slot name="paginacion">
            {{ $marcas->links() }}
        </x-slot>
    </x-table.tabla>
</div>
