<div class="card">
    <div class="table-responsive">
        <table class="table table-sm table-bordered table-hover table-striped">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Acción</th>
                    <th>Comentario</th>
                    <th>Usuario</th>
                    <th>Fecha Hora</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comentarios as $comentario)
                    <tr>
                        <td>{{ $loop->iteration + $comentarios->firstItem() - 1 }}</td>
                        <td>{{ $comentario->accion->accion ?? 'S/D' }}</td>
                        <td>{{ $comentario->comentario ?? 'S/D' }}</td>
                        <td>{{ $comentario->creadopor->nombrecompleto ?? 'S/D' }}</td>
                        <td>{{ $comentario->created_at->format('d/m/Y H:i:s') ?? 'S/D' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted font-italic">
                            Sin resultados coincidentes...
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center">
        {{-- IZQUIERDA --}}
        <div class="">
            {{ $comentarios->links() }}
        </div>

        {{-- DERECHA --}}
        <div class="col-md-8">
            <x-adminlte-button theme="outline-secondary" label="Cerrar" icon="fas fa-window-close" class="btn-sm float-right"
            data-dismiss="modal" wire:click="cerrarModal" />
        </div>
    </div>
</div>
