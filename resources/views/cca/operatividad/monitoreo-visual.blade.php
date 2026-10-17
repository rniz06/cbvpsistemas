
@extends('adminlte::page')

@section('title', 'Monitoreo Visual de Operatividad')

@section('content_header')
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <h1 class="mb-2 mb-md-0">
            Monitoreo Visual de Operatividad
        </h1>

        <div class="d-flex flex-wrap align-items-center" style="gap: 12px;">
            <div class="d-flex align-items-center">
                <span class="leyenda-color estado-completo"></span>
                <small>Operativa</small>
            </div>

            <div class="d-flex align-items-center">
                <span class="leyenda-color estado-sin-conductores"></span>
                <small>Sin conductores</small>
            </div>

            <div class="d-flex align-items-center">
                <span class="leyenda-color estado-sin-personal"></span>
                <small>Sin personal</small>
            </div>

            <div class="d-flex align-items-center">
                <span class="leyenda-color estado-inoperativo"></span>
                <small>Inoperativa</small>
            </div>
        </div>
    </div>

    <style>
        .leyenda-color {
            display: inline-block;
            width: 15px;
            height: 15px;
            border-radius: 3px;
            margin-right: 5px;
            flex-shrink: 0;
        }

        .estado-completo {
            background-color: #28a745;
        }

        .estado-sin-conductores {
            background-color: #17a2b8;
        }

        .estado-sin-personal {
            background-color: #ffc107;
        }

        .estado-inoperativo {
            background-color: #dc3545;
        }
    </style>
@stop

@section('content')
    @livewire('cca.operatividad.monitoreo-visual')
@stop
