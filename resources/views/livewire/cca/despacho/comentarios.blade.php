<div>

    @if ($mostrarFormAgregarComentario)
        <livewire:cca.despacho.comentario-agregar servicio="{{ $servicio }}" lazy />
    @endif

    {{-- Tabla de comentarios del servicio existente --}}
    <x-table.table titulo="Comentarios" ocultarBuscador personalizarPaginacion="paginadoComentarios">

        <x-slot name="headerBotones">
            <x-adminlte-button class="btn-sm" type="button"
                    label="{{ $mostrarFormAgregarComentario ? 'Cancelar' : 'Agregar Comentario' }}"
                    icon="fas fa-{{ $mostrarFormAgregarComentario ? 'minus' : 'plus' }}" theme="outline-success"
                    wire:click="$toggle('mostrarFormAgregarComentario')" />
        </x-slot>

        <x-slot name="cabeceras">
            <th>Comentario:</th>
            <th>Usuario:</th>
            <th>Fecha y Hora:</th>
        </x-slot>
        @forelse ($comentarios as $comentario)
            <tr>
                <td>{{ $comentario->comentario ?? 'N/A' }}</td>
                <td>{{ $comentario->nombrecompleto ?? 'N/A' }}</td>
                <td>{{ $comentario->created_at->format('d/m/Y H:i:s') }} Hs.</td>
            </tr>
        @empty
            <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
        @endforelse
        <x-slot name="paginacion">
            {{ $comentarios->links() }}
        </x-slot>
    </x-table.table>
</div>
