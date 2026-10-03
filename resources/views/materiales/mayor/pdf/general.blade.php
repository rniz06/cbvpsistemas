@extends('layouts.pdf.plantilla')

{{-- @section('titulo', 'TITULO') --}}

@section('departamento', 'Departamento de Matenimiento de Materiales')

{{-- Definimos los logos para este reporte --}}
{{-- @section('logo_izq', public_path('img/logos/logo-especial.png')) --}}
@section('logo_der', public_path('img/logos/dmm-logo.webp'))


@section('contenido')
    {{-- <h2 style="text-align: center">Mayor</h2> --}}

    <div class="subtitulo" style="margin-top: 1rem">Material Mayor</div>

    <table class="tabla">
        <thead class="tabla-thead">
            <tr>
                <th>Móvil</th>
                <th>Compañía</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Transmisión</th>
                <th>Eje</th>
                <th>Combustible</th>
                <th>Operatividad</th>
                <th>Año</th>
                <th>Chapa</th>
                <th>C. delanteras</th>
                <th>C. traseras</th>
            </tr>
        </thead>

        <tbody class="tabla-tbody">
            @forelse ($moviles as $movil)
                <tr>
                    <td>{{ $movil->movil ?? 'S/D' }}</td>
                    <td>{{ $movil->compania ?? 'S/D' }}</td>
                    <td>{{ $movil->marca ?? 'S/D' }}</td>
                    <td>{{ $movil->modelo ?? 'S/D' }}</td>
                    <td>{{ $movil->transmision ?? 'S/D' }}</td>
                    <td>{{ $movil->eje ?? 'S/D' }}</td>
                    <td>{{ $movil->combustible ?? 'S/D' }}</td>
                    <td>{{ $movil->operatividad ?? 'S/D' }}</td>
                    <td>{{ $movil->anho ?? 'S/D' }}</td>
                    <td>{{ $movil->chapa ?? 'S/D' }}</td>
                    <td>{{ $movil->cubiertas_frente ?? 'S/D' }}</td>
                    <td>{{ $movil->cubiertas_atras ?? 'S/D' }}</td>
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
