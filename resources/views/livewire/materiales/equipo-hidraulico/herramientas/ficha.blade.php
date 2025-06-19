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

    <h4>Herramientas</h4>
    <div class="row">
        <x-callout.ficha colClass="col-md-2 col-sm-6 mb-3"
            titulo="Herramienta">{{ $herramienta->tipo ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha colClass="col-md-2 col-sm-6 mb-3"
            titulo="Marca">{{ $herramienta->marca ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha colClass="col-md-2 col-sm-6 mb-3"
            titulo="Estado"><span class="badge badge-{{ $herramienta->operatividad == 'OPERATIVO' ? 'success' : 'danger' }}">{{ $herramienta->operatividad ?? 'N/A' }}</span></x-callout.ficha>
    </div>

    @if ($mostrarFormAgregarAccion)
        @livewire('materiales.equipo-hidraulico.herramientas.agregar-accion', ['hidraulico_id' => $hidraulico->id_hidraulico, 'herramienta_id' => $herramienta->id_hidraulico_herr])
    @endif

    {{-- Comentarios de Herramientas --}}
    <div class="col-md-12">
        <x-table.table titulo="Comentarios de Herramientas" ocultarBuscador>

            <x-slot name="headerBotones">
                @can('Equipos Hidraulicos Herramienta Agregar Accion')
                <x-adminlte-button class="btn-sm" type="button"
                    label="{{ $mostrarFormAgregarAccion ? 'Cancelar' : 'Agregar Accion' }}"
                    icon="fas fa-{{ $mostrarFormAgregarAccion ? 'minus' : 'plus' }}" theme="outline-success"
                    wire:click="$toggle('mostrarFormAgregarAccion')" />
            @endcan
            </x-slot>

            <x-slot name="cabeceras">
                <th>Accion:</th>
                <th>Comentario:</th>
                <th>Usuario:</th>
                <th>Fecha y Hora:</th>
            </x-slot>

            @forelse ($comentarios as $comentario)
                <tr>
                    <td>{{ $comentario->accion ?? 'N/A' }}</td>
                    <td>{{ $comentario->comentario ?? 'N/A' }}</td>
                    <td>{{ $comentario->nombrecompleto ?? 'N/A' }}</td>
                    <td>{{ date('d/m/Y H:m:s', strtotime($comentario->created_at)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center font-italic">No hay comentarios disponibles.</td>
                </tr>
            @endforelse
            <x-slot name="paginacion">
                {{ $comentarios->links() }}
            </x-slot>
        </x-table.table>
    </div>
</div>
