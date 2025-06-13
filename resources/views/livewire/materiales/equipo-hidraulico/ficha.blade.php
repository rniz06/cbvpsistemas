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
            titulo="Estado"><span class="badge badge-{{ $hidraulico->operatividad == 'OPERATIVO' ? 'success' : 'danger' }}">{{ $hidraulico->operatividad ?? 'N/A' }}</span></x-callout.ficha>
    </div>

    @if ($mostrarFormAgregarHerramienta)
        @livewire('materiales.equipo-hidraulico.agregar-herramienta', ['hidraulico_id' => $hidraulico->id_hidraulico])
    @endif

    <x-table.table titulo="Herramientas" ocultarBuscador personalizarPaginacion="paginadoHerramientas">
        <x-slot name="headerBotones">
            @can('Equipos Hidraulicos Agregar Herramienta')
                <x-adminlte-button class="btn-sm" type="button"
                    label="{{ $mostrarFormAgregarHerramienta ? 'Cancelar' : 'Agregar Herramienta' }}"
                    icon="fas fa-{{ $mostrarFormAgregarHerramienta ? 'minus' : 'plus' }}" theme="outline-success"
                    wire:click="$toggle('mostrarFormAgregarHerramienta')" />
            @endcan
        </x-slot>

        <x-slot name="cabeceras">
            <th>Tipo:</th>
            <th>Marca:</th>
            <th>Modelo:</th>
            <th>Motor:</th>
            <th>Estado:</th>
        </x-slot>

        @forelse ($herramientas as $herramienta)
            <tr>
                <td>{{ $herramienta->tipo ?? 'N/A' }}</td>
                <td>{{ $herramienta->marca ?? 'N/A' }}</td>
                <td>{{ $herramienta->modelo ?? 'N/A' }}</td>
                <td>{{ $herramienta->motor ?? 'N/A' }}</td>
                <td>{{ $herramienta->operatividad ?? 'N/A' }}</td>
                @can('Equipos Hidraulicos Herramientas Ver')
                    <td>
                        <a href="{{ route('materiales.hidraulicos.herramientas.show', [
                            'hidraulico' => $hidraulico->id_hidraulico,
                            'herramienta' => $herramienta->id_hidraulico_herr,
                        ]) }}"
                            class="btn btn-block btn-sm btn-success">Ver Ficha</a>
                    </td>
                @endcan
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center">No hay datos.</td>
            </tr>
        @endforelse
        <x-slot name="paginacion">
            {{ $herramientas->links() }}
        </x-slot>
    </x-table.table>

    @if ($mostrarFormAgregarAccion)
        @livewire('materiales.equipo-hidraulico.agregar-accion', ['hidraulico_id' => $hidraulico->id_hidraulico])
    @endif

    <x-table.table titulo="Comentarios" ocultarBuscador personalizarPaginacion="paginadoComentarios">
        <x-slot name="headerBotones">
            @can('Equipos Hidraulicos Agregar Accion')
                <x-adminlte-button class="btn-sm" type="button"
                    label="{{ $mostrarFormAgregarAccion ? 'Cancelar' : 'Agregar Acción' }}"
                    icon="fas fa-{{ $mostrarFormAgregarAccion ? 'minus' : 'plus' }}" theme="outline-success"
                    wire:click="$toggle('mostrarFormAgregarAccion')" />
            @endcan
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
                <td>{{ date('d/m/Y H:m:s', strtotime($comentario->created_at)) }}</td>
            </tr>
        @endforeach
        <x-slot name="paginacion">
            {{ $comentarios->links() }}
        </x-slot>
    </x-table.table>
</div>
