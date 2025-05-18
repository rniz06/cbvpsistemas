@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Conductores')
@section('content_header_title', 'Conductores')
@section('content_header_subtitle', 'Crear')

{{-- Content body: main page content --}}

@section('content_body')

    <x-form-horizontal title="Agregar Conductor" action="{{ route('conductores.store') }}">
        <x-select-horizontal label="Seleccionar Conductor" id="personal_id" name="personal_id">
            <option>Seleccionar...</option>
        </x-select-horizontal>
        <x-input-horizontal label="Resolución" name="resolucion" placeholder="Resolución..." />
        <x-input-horizontal label="Resolución Enlace (Opcional)" name="resolucion_enlace"
            placeholder="Resolucion Enlace..." />
        <x-input-horizontal type="date" label="Fecha de realización del Curso" name="fecha_curso" />

        <x-select-horizontal label="Ciudad de realización" id="ciudad_curso_id" name="ciudad_curso_id">
            <option>Seleccionar</option>
            @foreach ($ciudades as $ciudad)
                <option value="{{ $ciudad->idciudades }}"
                    {{ old('ciudad_curso_id') == $ciudad->idciudades ? 'selected' : '' }}>
                    {{ $ciudad->ciudad ?? 'N/A' }}
                </option>
            @endforeach
        </x-select-horizontal>

        <x-select-horizontal label="Tipo de vehiculo" name="tipo_vehiculo_id">
            @foreach ($tipoVehiculos as $tipoVehiculo)
                <option value="{{ $tipoVehiculo->idconductor_tipo_vehiculo }}" {{ old('tipo_vehiculo_id') == $tipoVehiculo->idconductor_tipo_vehiculo ? 'selected' : '' }}>
                    {{ $tipoVehiculo->tipo ?? 'N/A' }}
                </option>
            @endforeach
        </x-select-horizontal>

        <x-input-horizontal label="Número de Licencia" name="numero_licencia" placeholder="Número de Licencia..." />

        <x-select-horizontal label="Municipio" id="ciudad_licencia_id" name="ciudad_licencia_id">
            <option>Seleccionar</option>
            @foreach ($ciudades as $ciudad)
                <option value="{{ $ciudad->idciudades }}" {{ old('ciudad_licencia_id') == $ciudad->idciudades ? 'selected' : '' }}>
                    {{ $ciudad->ciudad ?? 'N/A' }}
                </option>
            @endforeach
        </x-select-horizontal>

        <x-select-horizontal label="Clase" name="clase_licencia_id">
            @foreach ($licencias as $licencia)
                <option value="{{ $licencia->idconductor_clase_licencia }}" {{ old('clase_licencia_id') == $licencia->idconductor_clase_licencia ? 'selected' : '' }}>
                    {{ $licencia->clase ?? 'N/A' }}
                </option>
            @endforeach
        </x-select-horizontal>

        <x-slot name="buttons">
            <x-button type="submit">Guardar</x-button>
        </x-slot>
    </x-form-horizontal>

@stop

@push('css')
    <style>
        /* Corrige estilos del select2 */
        .selection span {
            height: 38px !important;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('#personal_id').select2({
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
                    personal.nombrecompleto + ' - ' + personal.codigo + ' - ' + personal.categoria + ' - ' + personal.compania + 
                    '</div>');
            }

            // Formato para mostrar el elemento seleccionado
            function formatPersonalSelection(personal) {
                return personal.nombrecompleto ? personal.nombrecompleto + ' - ' + personal.codigo + ' - ' +
                    personal
                    .categoria : personal.text;
            }

            $('#ciudad_curso_id').select2({
                placeholder: 'Seleccionar...',
                language: "es",

            });

            $('#ciudad_licencia_id').select2({
                placeholder: 'Seleccionar...',
                language: "es",

            });
        });
    </script>
@endpush
