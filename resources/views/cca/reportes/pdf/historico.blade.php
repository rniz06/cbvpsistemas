@extends('layouts.pdf.plantilla')

{{-- @section('titulo', 'TITULO') --}}

@section('departamento', 'Central de Comunicaciones y Alarmas')

{{-- Definimos los logos para este reporte --}}
{{-- @section('logo_izq', public_path('img/logos/logo-especial.png'))
    @section('logo_der', public_path('img/logos/logo-secundario.png')) --}}


@section('contenido')
    <div class="subtitulo">Reporte desde fecha {{ date('d/m/Y', strtotime($fecha_desde)) }} hasta
        {{ date('d/m/Y', strtotime($fecha_hasta)) }}</div>

    <table class="tabla">
        <thead class="tabla-thead">
            <tr>
                <td>Compañia</td>
                <td>Servicio</td>
                <td>Clasificación</td>
                <td>Móvil</td>
                <td>A Cargo</td>
                <td>Chofer</td>
                <td>Tripulantes</td>
                <td>Fecha</td>
            </tr>
        </thead>

        <tbody class="tabla-tbody">
            @forelse ($historicos as $historico)
                <tr>
                    <td>{{ $historico->compania ?? 'S/D' }}</td>
                    <td>{{ $historico->servicio ?? 'S/D' }}</td>
                    <td>{{ $historico->clasificacion ?? 'S/D' }}</td>
                    <td>{{ $historico->movil ?? 'S/D' }}</td>
                    <td>{{ $historico->acargo ?? 'S/D' }}</td>
                    <td>{{ $historico->chofer ?? 'S/D' }}</td>
                    <td>{{ $historico->cantidad_tripulantes ?? 'S/D' }}</td>
                    <td>{{ $historico->fecha_alfa->format('d/m/Y') ?? 'S/D' }}</td>
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
