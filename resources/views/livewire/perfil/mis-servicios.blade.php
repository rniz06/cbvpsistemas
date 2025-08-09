<div class="table-responsive tab-pane" id="mis_servicios">
    <table class="table table-striped table-bordered table-sm p-0">
        <thead>
            <tr>
                <th>Servicio:</th>
                <th>A cargo:</th>
                <th>Chofer:</th>
                <th>Total:</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($servicios as $servicio)
                <tr>
                    <td>{{ $servicio->servicio ?? 'S/D' }}</td>
                    <td>{{ $servicio->cantidad_acargo ?? 'S/D' }}</td>
                    <td>{{ $servicio->cantidad_chofer ?? 'S/D' }}</td>
                    <td>{{ $servicio->total_general ?? 'S/D' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center">Sin registros de servicios...</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
