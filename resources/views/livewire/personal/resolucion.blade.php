<div class="card">
        <div class="card-header">
            <h3 class="card-title">Resoluciones</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>N° Resolucion:</th>
                        <th>Concepto:</th>
                        <th>Fecha:</th>
                        <th>Origen:</th>
                        <th style="width: 40px">Descargar:</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($resoluciones as $resolucion)
                        <tr>
                            <td>#</td>
                            <td>{{ $resolucion->n_resolucion ?? 'N/A' }}</td>
                            <td>{{ $resolucion->concepto ?? 'N/A' }}</td>
                            <td>{{ date('d/m/Y', strtotime($resolucion->fecha)) ?? 'N/A' }}</td>
                            <td>{{ $resolucion->fuente_origen ?? 'N/A' }}</td>
                            <td><a href="http://resoluciones.cbvp.org.py/descargar-resolucion/{{ $resolucion->id_resolucion }}" target="_blank"
                                    class="btn btn-sm btn-success"><i class="fas fa-file-pdf"></i></a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Sin datos...</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                {{ $resoluciones->links() }}
            </ul>
        </div>
    </div>