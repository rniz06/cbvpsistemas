<div>
    <!-- Tabla -->
    <x-tabla titulo="Listado de Conductores" excel pdf>
        <x-slot name="headerBotones">
            @can('Conductores Crear')
                <a href="{{ route('materiales.conductores.create') }}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Agregar
                    Conductor</a>
            @endcan
        </x-slot>

        <x-slot name="cabeceras">
            <th>Codigo:</th>
            <th>Nombre Completo:</th>
            <th>Compañia:</th>
            <th>Estado</th>
            <th>Ver Ficha:</th>
        </x-slot>

        @forelse ($conductores as $conductor)
            <tr wire:click="seleccionado({{ $conductor->id_conductor_bombero }})">
                <td>{{ $conductor->codigo }}</td>
                <td>{{ $conductor->nombrecompleto }}</td>
                <td>{{ $conductor->compania }}</td>
                <td>{{ $conductor->estado }}</td>
                <td>
                    @can('Conductores Ver')
                        <a href="{{ route('materiales.conductores.show', $conductor->id_conductor_bombero) }}"
                            class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Ver Ficha</a>
                    @endcan
                    @can('Conductores Editar')
                        <a href="{{ route('materiales.conductores.edit', $conductor->id_conductor_bombero) }}"
                            class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Actualizar</a>
                    @endcan
                </td>
            </tr>
        @empty
            <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
        @endforelse
        <x-slot name="paginacion">
            {{ $conductores->links() }}
        </x-slot>
    </x-tabla>

</div>

@push('scripts')
    {{-- Script para boton guardar --}}
    <script>
        const btnGuardar = document.getElementById('btn-grabar');
        if (btnGuardar) {
            btnGuardar.addEventListener('click', function() {
                // Obtener el modo actual directamente de Livewire                 
                const modoActual = @this.get('modo');

                let titulo = modoActual === 'modificar' ? 'MODIFICAR' : 'AGREGAR';
                let mensaje = modoActual === 'modificar' ? '¿DESEAS ACTUALIZAR EL REGISTRO?' :
                    '¿DESEAS GRABAR EL NUEVO REGISTRO?';
                let respuesta = modoActual === 'modificar' ? 'Registro Actualizado Con Éxito' :
                    'Registro Creado Con Éxito';

                Swal.fire({
                    title: titulo,
                    text: mensaje,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#458E49",
                    confirmButtonText: "SI",
                    cancelButtonText: "NO",
                    closeOnConfirm: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.grabar();
                        Swal.fire({
                            title: "Respuesta",
                            text: respuesta,
                            icon: "success"
                        });
                    }
                });
            });
        }
    </script>

    {{-- Script para boton eliminar --}}
    <script>
        const btnEliminar = document.getElementById('btn-eliminar');
        if (btnEliminar) {
            btnEliminar.addEventListener('click', function() {
                Swal.fire({
                    title: "ELIMINAR",
                    text: "¿DESEAS ELIMINAR EL REGISTRO SELECCIONADO?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#458E49",
                    confirmButtonText: "SI",
                    cancelButtonText: "NO",
                    closeOnConfirm: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.eliminar();
                        Swal.fire({
                            title: "Respuesta",
                            text: "Registro Eliminado Con Exito",
                            icon: "success"
                        });
                    }
                });
            });
        }
    </script>
    <!-- Script para select2 -->
    <script>
        $('#personal').select2({
            placeholder: 'Seleccionar...',
            language: "es",
            ajax: {
                url: '{{ route('personal.search') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 2,
            templateResult: formatPersonal,
            templateSelection: formatPersonalSelection
        });

        // Formato para mostrar los resultados en el dropdown
        function formatPersonal(personal) {
            if (personal.loading) return personal.text;

            return $('<div class="select2-result-personal">' +
                personal.nombrecompleto + ' - ' + personal.codigo + ' - ' + personal.categoria + ' - ' + personal
                .compania +
                '</div>');
        }

        // Formato para mostrar el elemento seleccionado
        function formatPersonalSelection(personal) {
            return personal.nombrecompleto ? personal.nombrecompleto + ' - ' + personal.codigo + ' - ' + personal
                .categoria : personal.text;
        }
    </script>
@endpush

@push('css')
    <style>
        /* Corrige estilos del select2 */
        .selection span {
            height: 38px !important;
        }
    </style>
@endpush
