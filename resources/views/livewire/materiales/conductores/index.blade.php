<div>
    <!-- Formulario -->
    {{-- <x-card-form>
        <x-card-select class="col-3" id="personal" label="Conductor" campo="personal_id">
        </x-card-select>

        <x-card-input class="col-3" label="Resolución de Comandancia" placeholder="Resolución de Comandancia..."
            campo="resolucion" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />

        <x-card-input class="col-3" label="Fecha de realización del Curso" type="date" campo="fecha_curso"
            :disabled="in_array($modo, ['inicio', 'seleccionado'])" />

        <x-card-select class="col-3" id="ciudadRealizacion" label="Ciudad de realización" campo="ciudad_curso_id"
            :disabled="in_array($modo, ['inicio', 'seleccionado'])">
            <option value="">Seleccione una ciudad</option>
            @foreach ($ciudades as $ciudad)
                <option value="{{ $ciudad->idciudades }}">{{ $ciudad->ciudad ?? 'N/A' }}</option>
            @endforeach
        </x-card-select>

        <x-card-select class="col-3" label="Tipo de vehiculo" campo="tipo_vehiculo_id" :disabled="in_array($modo, ['inicio', 'seleccionado'])">
            @foreach ($tipoVehiculos as $tipoVehiculo)
                <option value="{{ $tipoVehiculo->idconductor_tipo_vehiculo }}">{{ $tipoVehiculo->tipo ?? 'N/A' }}
                </option>
            @endforeach
        </x-card-select>

        <x-card-input class="col-3" label="Número de Licencia" placeholder="Número de Licencia..."
            campo="numero_licencia" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />

        <x-card-select class="col-3" id="ciudadLicencia" label="Municipio" campo="ciudad_licencia_id"
            :disabled="in_array($modo, ['inicio', 'seleccionado'])">
            <option value="">Seleccione una ciudad</option>
            @foreach ($ciudades as $ciudad)
                <option value="{{ $ciudad->idciudades }}">{{ $ciudad->ciudad ?? 'N/A' }}</option>
            @endforeach
        </x-card-select>

        <x-card-select class="col-3" label="Clase" campo="clase_licencia_id" :disabled="in_array($modo, ['inicio', 'seleccionado'])">
            @foreach ($licencias as $licencia)
                <option value="{{ $licencia->idconductor_clase_licencia }}">{{ $licencia->clase ?? 'N/A' }}</option>
            @endforeach
        </x-card-select>

        <x-slot name="buttons">
            @can('Conductores Crear')
                <x-button type="button" icon="fas fa-plus" color="success" click="agregar"
                    :disabled="in_array($modo, ['agregar', 'modificar', 'seleccionado'])">Agregar</x-button>
            @endcan

            @can('Conductores Editar')
                <x-button type="button" icon="fas fa-edit" color="primary" click="editar"
                    :disabled="in_array($modo, ['inicio', 'modificar', 'agregar'])">Modificar</x-button>
            @endcan

            @can('Conductores Eliminar')
                <x-button type="button" icon="fas fa-trash" color="danger" id="btn-eliminar"
                    :disabled="in_array($modo, ['agregar', 'modificar', 'inicio'])">Eliminar</x-button>
            @endcan

            @canany(['Conductores Crear', 'Conductores Editar'])
                <x-button type="submit" color="default" :disabled="in_array($modo, ['inicio', 'seleccionado'])" id="btn-grabar">Grabar</x-button>
            @endcanany

            <x-button type="button" icon="fas fa-window-close" color="warning" click="cancelar"
                :disabled="in_array($modo, ['inicio'])">Cancelar</x-button>
        </x-slot>
    </x-card-form> --}}

    <!-- Tabla -->
    <x-tabla titulo="Listado de Conductores" excel pdf>
        <x-slot name="headerBotones">
            <a href="{{ route('conductores.create') }}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Agregar
                Conductor</a>
        </x-slot>

        <x-slot name="cabeceras">
            <th>Codigo:</th>
            <th>Nombre Completo:</th>
            <th>Compañia:</th>
            <th>Estado</th>
            <th>Ver Ficha:</th>
        </x-slot>

        @foreach ($conductores as $conductor)
            <tr wire:click="seleccionado({{ $conductor->id_conductor_bombero }})">
                <td>{{ $conductor->codigo }}</td>
                <td>{{ $conductor->nombrecompleto }}</td>
                <td>{{ $conductor->compania }}</td>
                <td>{{ $conductor->estado }}</td>
                <td>
                    @can('Conductores Ver')
                        <a href="{{ route('conductores.show', $conductor->id_conductor_bombero) }}"
                            class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Ver Ficha</a>
                    @endcan
                </td>
            </tr>
        @endforeach
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
