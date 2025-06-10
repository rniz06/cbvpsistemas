<div>
    <h4>Ficha de Compañia</h4>
    <div class="row">
        <x-callout.ficha titulo="Compañía">{{ $compania->compania ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Ciudad">{{ $compania->ciudad ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Departamento">{{ $compania->departamento ?? 'N/A' }}</x-callout.ficha>
    </div>

    {{-- Tabla de Moviles --}}
    <div class="col-md-12">
        <x-table.table titulo="Móviles" ocultarBuscador personalizarPaginacion="paginadoMoviles">

            <x-slot name="cabeceras">
                <th>Móvil:</th>
                <th>Estado:</th>
                <th>Marca:</th>
            </x-slot>

            @foreach ($moviles as $movil)
                <tr>
                    <td>{{ $movil->tipo ?? 'N/A' }}-{{ $movil->movil ?? 'N/A' }}</td>
                    <td><span class="badge badge-{{ $movil->operatividad == 'OPERATIVO' ? 'success' : 'danger' }}">{{ $movil->operatividad }}</span></td>
                    <td>{{ $movil->marca ?? 'N/A' }}</td>
                    @can('Material Mayor Ver')
                        <td><a href="{{ route('materiales.mayor.show', $movil->id_movil) }}" class="btn btn-sm btn-{{ $movil->operatividad == 'OPERATIVO' ? 'success' : 'danger' }} btn-block">Ver Ficha</a></td>
                    @endcan
                </tr>
            @endforeach
            <x-slot name="paginacion">
                {{ $moviles->links() }}
            </x-slot>
        </x-table.table>
    </div>
</div>
