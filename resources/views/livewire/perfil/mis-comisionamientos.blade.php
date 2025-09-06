<div class="table-responsive tab-pane" id="mis_comisionamientos">
    <table class="table table-striped table-bordered table-sm p-0">
        <thead>
            <tr>
                <th>Cargo:</th>
                <th>Rango:</th>
                <th>Cod. Comi:</th>
                <th>Comisionado:</th>
                <th>En:</th>
                <th>N° Resolucion:</th>
                <th>F. Inicio:</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($comisionamientos as $comisionamiento)
                <tr>
                     <td>{{ $comisionamiento->cargo ?? 'S/D' }}</td>
                      <td>{{ $comisionamiento->rango ?? 'S/D' }}</td>
                       <td>{{ $comisionamiento->codigo_comisionamiento ?? 'S/D' }}</td>
                    <td>{{ $comisionamiento->compania ?? 'S/D' }}</td>
                    <td>{{ $comisionamiento->direccion ?? 'S/D' }}</td>
                    <td>{{ $comisionamiento->n_resolucion ?? 'S/D' }}</td>
                    <td>{{ $comisionamiento->fecha_inicio ? $comisionamiento->fecha_inicio->format('d / m / Y') : 'S/D' }}
                    </td>
                    @if ($comisionamiento->resolucion_id)
                        <td><a href="https://resoluciones.cbvp.org.py/descargar-resolucion/{{ $comisionamiento->resolucion_id }}"
                                target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file-pdf"></i></a></td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center">Sin registros de Comisionamientos...</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $comisionamientos->links() }}
</div>
