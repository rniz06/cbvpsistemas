<div>
    <h4 class="text-center">Materiales Mayor - Ultimas actualizaciones</h4>

    {{-- Tabla de Moviles --}}
    <div class="col-md-12 row">

        @php
            $heads = ['Móvil', 'Acción:', 'Comentario:', 'Usuario:', 'Fecha y Hora:'];
            $config = [
                'lengthMenu' => [5, 10, 15, 20],
                'searching' => false, // 👈 Esto oculta el buscador
                'language' => [
                    'url' => '//cdn.datatables.net/plug-ins/2.3.2/i18n/es-ES.json',
                ],
            ];
        @endphp
        <x-adminlte-datatable id="table1" :heads="$heads" striped bordered compressed hoverable :config="$config"
            with-footer>
            @foreach ($moviles as $movil)
                <tr>
                    <td>{{ $movil->tipo ?? 'N/A' }}-{{ $movil->movil ?? 'N/A' }}</td>
                    <td>{{ $movil->accion ?? 'N/A' }}</td>
                    <td>{{ $movil->comentario ?? 'N/A' }}</td>
                    <td>{{ $movil->nombrecompleto ?? 'N/A' }}</td>
                    <td>{{ $movil->created_at }}</td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>

    <h4 class="text-center">Equipos Hidráulicos - Ultimas actualizaciones</h4>

    {{-- Tabla de Hidraulicos --}}
    <div class="col-md-12 row">

        @php
            $heads = ['Compañia', 'Marca', 'Acción:', 'Comentario:', 'Usuario:', 'Fecha y Hora:'];
            $config = [
                'lengthMenu' => [5, 10, 15, 20],
                'searching' => false, // 👈 Esto oculta el buscador
                'language' => [
                    'url' => '//cdn.datatables.net/plug-ins/2.3.2/i18n/es-ES.json',
                ],
            ];
        @endphp
        <x-adminlte-datatable id="table2" :heads="$heads" striped bordered compressed hoverable :config="$config"
            with-footer>
            @foreach ($hidraulicos as $hidraulico)
                <tr>
                    <td>{{ $hidraulico->compania ?? 'N/A' }}</td>
                    <td>{{ $hidraulico->marca ?? 'N/A' }}</td>
                    <td>{{ $hidraulico->accion ?? 'N/A' }}</td>
                    <td>{{ $hidraulico->comentario ?? 'N/A' }}</td>
                    <td>{{ $hidraulico->nombrecompleto ?? 'N/A' }}</td>
                    <td>{{ $hidraulico->created_at }}</td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</div>
