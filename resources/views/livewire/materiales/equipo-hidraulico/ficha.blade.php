<div>
    <h4>Ficha de Equip. Hidraulico</h4>
    <div class="row">
        <x-callout.ficha colClass="col-md-2 col-sm-6 mb-3"
            titulo="Compañía">{{ $hidraulico->compania ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha colClass="col-md-2 col-sm-6 mb-3"
            titulo="Marca">{{ $hidraulico->marca ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha colClass="col-md-2 col-sm-6 mb-3"
            titulo="Modelo">{{ $hidraulico->modelo ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha colClass="col-md-2 col-sm-6 mb-3"
            titulo="Motor">{{ $hidraulico->motor ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha colClass="col-md-2 col-sm-6 mb-3"
            titulo="Año de fabricación">{{ $hidraulico->anho ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha colClass="col-md-2 col-sm-6 mb-3"
            titulo="Estado">{{ $hidraulico->operatividad ?? 'N/A' }}</x-callout.ficha>
    </div>

    <x-table.table titulo="Herramientas" ocultarBuscador personalizarPaginacion="paginadoHerramientas">
        <x-slot name="headerBotones">

            {{-- @can('Material Mayor Agregar Accion')
                <x-button.button click="openFormAgregarAccion" color="btn-block btn-outline-secondary btn-sm"
                    icon="fas fa-plus" class="ml-2 btn-sm float-right">
                    Agregar Accion
                </x-button.button>
            @endcan

            @livewire('materiales.mayor.agregar-accion', ['movil_id' => $movil->id_movil]) --}}

        </x-slot>

        <x-slot name="cabeceras">
            <th>Tipo:</th>
            <th>Marca:</th>
            <th>Modelo:</th>
            <th>Motor:</th>
            <th>Estado:</th>
        </x-slot>

        @foreach ($herramientas as $herramienta)
            <tr>
                <td>{{ $herramienta->tipo ?? 'N/A' }}</td>
                <td>{{ $herramienta->marca ?? 'N/A' }}</td>
                <td>{{ $herramienta->modelo ?? 'N/A' }}</td>
                <td>{{ $herramienta->motor ?? 'N/A' }}</td>
                <td>{{ $herramienta->operatividad ?? 'N/A' }}</td>
            </tr>
        @endforeach
        <x-slot name="paginacion">
            {{ $herramientas->links() }}
        </x-slot>
    </x-table.table>

    <x-table.table titulo="Comentarios" ocultarBuscador personalizarPaginacion="paginadoComentarios">
        <x-slot name="headerBotones">

            {{-- @can('Equipos Hidraulicos Agregar Accion')
                <x-button.button click="openFormAgregarAccion" color="btn-block btn-outline-secondary btn-sm"
                    icon="fas fa-plus" class="ml-2 btn-sm float-right">
                    Agregar Accion
                </x-button.button>
            @endcan

            @livewire('materiales.mayor.agregar-accion', ['movil_id' => $movil->id_movil]) --}}

        </x-slot>

        <x-slot name="cabeceras">
            <th>Acción:</th>
            <th>Comentarios:</th>
            <th>Usuario:</th>
            <th>Fecha y Hora:</th>
        </x-slot>

        @foreach ($comentarios as $comentario)
            <tr>
                <td>{{ $comentario->accion ?? 'N/A' }}</td>
                <td>{{ $comentario->comentario ?? 'N/A' }}</td>
                <td>{{ $comentario->nombrecompleto ?? 'N/A' }}</td>
                <td>{{ date('d/m/Y h:m:s', strtotime($comentario->created_at)) }}</td>
            </tr>
        @endforeach
        <x-slot name="paginacion">
            {{ $comentarios->links() }}
        </x-slot>
    </x-table.table>
</div>
