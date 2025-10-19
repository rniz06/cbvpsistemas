@extends('layouts.pdf.plantilla')

{{-- @section('titulo', 'TITULO') --}}

@section('departamento', 'Central de Comunicaciones y Alarmas')

{{-- Definimos los logos para este reporte --}}
{{-- @section('logo_izq', public_path('img/logos/logo-especial.png'))
    @section('logo_der', public_path('img/logos/logo-secundario.png')) --}}


@section('contenido')

    <h2 style="text-align: center">Servicios Como Primera Respuesta</h2>

    <div class="subtitulo">Compañia: {{ $compania ?? 'S/D' }} Servicio:
        {{ $servicio ?? 'S/D' }} Clasificación: {{ $clasificacion ?? 'S/D' }} desde fecha
        {{ date('d/m/Y', strtotime($fecha_desde)) }} hasta
        {{ date('d/m/Y', strtotime($fecha_hasta)) }}</div>

    <table class="tabla">
        <thead class="tabla-thead">
            <tr>
                <td>Servicio</td>
                <td>Conteo</td>
            </tr>
        </thead>

        <tbody class="tabla-tbody">
            @forelse ($servicios as $servicio)
                <tr>

                    <td>{{ $servicio->servicio ?? 'S/D' }}</td>
                    <td>{{ $servicio->conteo ?? 'S/D' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" style="font-style: italic; text-align: center">SIN REGISTROS</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="firma">
        Emitido por: {{ $usuario->nombrecompleto ?? 'S/D' }}<br>
        @php
            $letraCategoria = $usuario->categoria ? substr($usuario->categoria, 0, 1) : 'N/A';
            $codigo = $usuario->codigo ?? 'N/A';
        @endphp
        <small>{{ "$letraCategoria-$codigo" }}</small>
    </div>
@endsection

@push('styles')
@endpush
