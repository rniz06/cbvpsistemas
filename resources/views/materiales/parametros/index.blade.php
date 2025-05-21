@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'M. Parametros')
@section('content_header_title', 'Materiales')
@section('content_header_subtitle', 'Parametros')

{{-- Content body: main page content --}}

@section('content_body')

    <h4>Configuración de parametros</h4>
    <hr>
    <h4 class="font-weight-bold">Material Mayor</h4>
    <div class="row">
        <!-- Cada callout ocupa 3 columnas (12/4=3) -->
        <a class="col-md-3 col-sm-6 text-dark" href="{{ route('materiales.mayor.marcas') }}">
            <div class="callout callout-warning">
                <h5>Marcas y Modelos</h5>
            </div>
        </a>

        @can('Material Mayor Transmision Listar')
            <a class="col-md-3 col-sm-6 text-dark" href="{{ route('materiales.mayor.transmision') }}">
                <div class="callout callout-warning">
                    <h5>Transmisión</h5>
                </div>
            </a>
        @endcan

        <a class="col-md-3 col-sm-6 text-dark" href="{{ route('materiales.mayor.ejes') }}">
            <div class="callout callout-warning">
                <h5>Ejes</h5>
            </div>
        </a>

        <a class="col-md-3 col-sm-6 text-dark" href="{{ route('materiales.mayor.combustibles') }}">
            <div class="callout callout-warning">
                <h5>Combustibles</h5>
            </div>
        </a>

        <!-- Segunda fila -->
        <a class="col-md-3 col-sm-6 text-dark" href="{{ route('materiales.mayor.acronimos') }}">
            <div class="callout callout-warning">
                <h5>Acrónimos</h5>
            </div>
        </a>

        <!-- Puedes agregar más callouts aquí -->
    </div>

    <hr>
    <h4 class="font-weight-bold">Equipo Hidraulico</h4>
    <h6>Equipo Hidraulico</h6>
    <div class="row">
        <!-- Cada callout ocupa 3 columnas (12/4=3) -->
        <a class="col-md-3 col-sm-6 text-dark" href="{{ route('materiales.hidraulico.motor') }}">
            <div class="callout callout-warning">
                <h5>Motor</h5>
            </div>
        </a>

        <a class="col-md-3 col-sm-6 text-dark" href="{{ route('materiales.hidraulico.marcas') }}">
            <div class="callout callout-warning">
                <h5>Marcas y Modelos</h5>
            </div>
        </a>
    </div>

    <h6>Herramientas</h6>
    <div class="row">
        <!-- Cada callout ocupa 3 columnas (12/4=3) -->
        <a class="col-md-3 col-sm-6 text-dark" href="{{ route('materiales.parametros') }}">
            <div class="callout callout-warning">
                <h5>Motor</h5>
            </div>
        </a>

        <a class="col-md-3 col-sm-6 text-dark" href="{{ route('materiales.parametros') }}">
            <div class="callout callout-warning">
                <h5>Marcas y Modelos</h5>
            </div>
        </a>

        <a class="col-md-3 col-sm-6 text-dark" href="{{ route('materiales.parametros') }}">
            <div class="callout callout-warning">
                <h5>Tipos</h5>
            </div>
        </a>
    </div>

@stop

@push('css')
@endpush

@push('js')
@endpush
