@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Conductores')
@section('content_header_title', 'Conductores')
@section('content_header_subtitle', 'Actualizar')

{{-- Content body: main page content --}}

@section('content_body')

    <x-form-horizontal color="warning" title="Agregar Conductor"
        action="{{ route('conductores.update', $conductor->id_conductor_bombero) }}">
        @method('put')
        <h4>Ficha de Conductor de:</h4>
                
        <div class="form-group row">
            <!-- Cada grupo (label + div) ocupa x columnas -->
            <div class="col-md-4 mb-3">
                <label class="form-label">Nombre Completo:</label>
                <div class="form-control">{{ $conductor->nombrecompleto }}</div>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Código:</label>
                <div class="form-control">{{ $conductor->codigo }}</div>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Categoría:</label>
                <div class="form-control">{{ $conductor->categoria }}</div>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Compañía:</label>
                <div class="form-control">{{ $conductor->compania }}</div>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Estado:</label>
                <select class="form-control bg-light" name="estado_id">
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id_conductor_estado }}"
                            {{ old('estado_id', $conductor->estado_id ?? '') == $estado->id_conductor_estado ? 'selected' : '' }}>
                            {{ $estado->estado ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <x-input-horizontal label="Resolución" name="resolucion" placeholder="Resolución..."
            value="{{ $conductor->resolucion }}" />
        <x-input-horizontal label="Resolución Enlace (Opcional)" name="resolucion_enlace" placeholder="Resolucion Enlace..."
            value="{{ $conductor->resolucion_enlace }}" />
        <x-input-horizontal type="date" label="Fecha de realización del Curso" name="fecha_curso"
            value="{{ $conductor->fecha_curso }}" />

        <x-select-horizontal label="Ciudad de realización" id="ciudad_curso_id" name="ciudad_curso_id">
            <option>Seleccionar</option>
            @foreach ($ciudades as $ciudad)
                <option value="{{ $ciudad->idciudades }}"
                    {{ old('ciudad_curso_id', $conductor->ciudad_curso_id ?? '') == $ciudad->idciudades ? 'selected' : '' }}>
                    {{ $ciudad->ciudad ?? 'N/A' }}
                </option>
            @endforeach
        </x-select-horizontal>

        <x-select-horizontal label="Tipo de vehiculo" name="tipo_vehiculo_id">
            @foreach ($tipoVehiculos as $tipoVehiculo)
                <option value="{{ $tipoVehiculo->idconductor_tipo_vehiculo }}"
                    {{ old('tipo_vehiculo_id', $conductor->tipo_vehiculo_id ?? '') == $tipoVehiculo->idconductor_tipo_vehiculo ? 'selected' : '' }}>
                    {{ $tipoVehiculo->tipo ?? 'N/A' }}
                </option>
            @endforeach
        </x-select-horizontal>

        <hr>
        <h4>Datos de la Licencia:</h4>
        
        <x-input-horizontal label="Número de Licencia" name="numero_licencia" placeholder="Número de Licencia..."
            value="{{ $conductor->numero_licencia }}" />

        <x-select-horizontal label="Municipio" id="ciudad_licencia_id" name="ciudad_licencia_id">
            <option>Seleccionar</option>
            @foreach ($ciudades as $ciudad)
                <option value="{{ $ciudad->idciudades }}"
                    {{ old('ciudad_licencia_id', $conductor->ciudad_licencia_id ?? '') == $ciudad->idciudades ? 'selected' : '' }}>
                    {{ $ciudad->ciudad ?? 'N/A' }}
                </option>
            @endforeach
        </x-select-horizontal>

        <x-select-horizontal label="Clase" name="clase_licencia_id">
            @foreach ($licencias as $licencia)
                <option value="{{ $licencia->idconductor_clase_licencia }}"
                    {{ old('clase_licencia_id', $conductor->clase_licencia_id ?? '') == $licencia->idconductor_clase_licencia ? 'selected' : '' }}>
                    {{ $licencia->clase ?? 'N/A' }}
                </option>
            @endforeach
        </x-select-horizontal>

        <x-slot name="buttons">
            <x-button type="submit" color="warning">Actualizar</x-button>
            <x-button-back href="{{ route('conductores.index') }}">Volver</x-button-back>
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
