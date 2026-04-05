<div>
    <x-table.tabla titulo="Lista de Marcas - Mat. Menor" pdf="pdf" excel="excel" dropdown_direccion="dropleft">

        @can('Material Menor Marcas Crear')
            <x-slot name="acciones">
                <a href="#" class="btn btn-sm dropdown-item"><i
                        class="fas fa-plus mr-2"></i>Añadir Marca</a>
            </x-slot>
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
                        @can('Material Menor Marcas Editar')
                            <a href="#"
                                class="btn dropdown-item btn-sm"><i class="fas fa-edit"></i> Editar</a>
                        @endcan

                        {{-- LINEA DIVISORIA --}}
                        <div class="dropdown-divider"></div>

                        {{-- ELIMINAR --}}
                        @can('Personal Eliminar')
                            {{-- @livewire('admin.usuarios.eliminar', ['usuario_id' => $usuario->id_usuario], key($usuario->id_usuario)) --}}
                            <a href="#"
                                class="btn dropdown-item btn-sm"><i class="fas fa-trash"></i> Eliminar</a>
                        @endcan
                    </x-tabla-dropdown>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...</td>
            </tr>
        @endforelse

        <x-slot name="paginacion">
            {{ $marcas->links() }}
        </x-slot>
    </x-table.tabla>
</div>