<div class="row">
    {{-- Do your work, then step back. --}}
    <h4>Ficha de Compañia: {{ $compania->compania ?? 'S/D' }}</h4>

    {{-- ITEMS --}}
    <div class="col-md-12">
        <x-table.tabla titulo="Material Menor" dropdown_direccion="dropleft" paginado="paginado">

            @can('Material Menor Crear')
                <x-slot name="acciones">
                    <x-adminlte-button label="Añadir Marca" class="btn-sm dropdown-item" icon="fas fa-plus" />
                </x-slot>
            @endcan

            <x-slot name="encabezados">
                {{-- NUMERO EN LA FILA --}}
                <th style="width: 10px">N°</th>

                {{-- NOMBRE --}}
                <th>Nombre</th>

                {{-- MARCA --}}
                <th>Marca</th>

                {{-- COMPAÑIA --}}
                <th>Estado</th>

                <th></th>

            </x-slot>

            @forelse ($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->componente->nombre ?? 'S/D' }}</td>
                    <td>{{ $item->marca->nombre ?? 'S/D' }}</td>
                    <td>
                        @if ($item->estado->operatividad === 'OPERATIVO')
                            <span class="badge badge-success">OPERATIVO</span>
                        @elseif ($item->estado->operatividad === 'INOPERATIVO')
                            <span class="badge badge-danger">INOPERATIVO</span>
                        @else
                            <span class="badge badge-secondary">S/D</span>
                        @endif
                    </td>
                    <td>
                        <a href="#"
                            class="btn btn-sm w-100 
                            @if ($item->estado->operatividad === 'OPERATIVO') btn-outline-success
                            @elseif ($item->estado->operatividad === 'INOPERATIVO')
                                btn-outline-danger
                            @else
                                btn-outline-secondary @endif">
                            <i class="fas fa-eye mr-1"></i> Ver Ficha
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                    </td>
                </tr>
            @endforelse

            <x-slot name="paginacion">
                {{ $items->links() }}
            </x-slot>
        </x-table.tabla>
    </div>
</div>
