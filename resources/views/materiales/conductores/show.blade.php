@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Conductores')
@section('content_header_title', 'Conductores')
@section('content_header_subtitle', 'Ver')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Mostrar un alert en caso de haber algun mensaje --}}
    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5><i class="fas fa-check-circle mr-2" style="color: #28a745"></i>{{ $message }}</h5>
        </div>
    @endif
    <h4>Ficha del Conductor:</h4>
    <x-adminlte-callout theme="success">
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
                <div class="form-control">{{ $conductor->estado }}</div>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Resolución de Comandancia::</label>
                <div class="form-control">{{ $conductor->resolucion }}</div>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Fecha de realización del Curso:</label>
                
                <div class="form-control">{{ date('d/m/Y', strtotime($conductor->fecha_curso)) }}</div>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Ciudad de realización:</label>
                <div class="form-control">{{ $conductor->ciudad_curso }}</div>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Tipo de vehiculo:</label>
                <div class="form-control">{{ $conductor->tipo_vehiculo   }}</div>
            </div>

        </div>
    </x-adminlte-callout>

    <h4>Datos de la Licencia:</h4>
    <x-adminlte-callout theme="success">
        <div class="form-group row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Número de Licencia:</label>
                <div class="form-control">{{ $conductor->numero_licencia ?? 'N/A' }}</div>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Municipio:</label>
                <div class="form-control">{{ $conductor->ciudad_licencia ?? 'N/A' }}</div>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Clase:</label>
                <div class="form-control">{{ $conductor->clase_licencia ?? 'N/A' }}</div>
            </div>
        </div>
    </x-adminlte-callout>

@stop

@push('css')
@endpush

@push('js')
@endpush
