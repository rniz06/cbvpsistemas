@extends('layouts.pdf.plantilla')

{{-- @section('titulo', 'TITULO') --}}

@section('departamento', 'Departamento de Matenimiento de Materiales')

{{-- Definimos los logos para este reporte --}}
@php
    $logo_der = public_path('img/logos/dmm-logo.webp');
@endphp


@section('contenido')

    <div class="subtitulo" style="margin-top: 1rem">Lista Mat. Menor Inoperativos</div>

    <table class="tabla">
        <thead class="tabla-thead">
            <tr>
                <th style="width: 10px">#</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Compañia</th>
            </tr>
        </thead>

        <tbody class="tabla-tbody">
            @forelse ($datos as $index => $inoperativo)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $inoperativo->componente->nombre ?? 'S/D' }}</td>
                    <td>{{ $inoperativo->componente->marca->nombre ?? 'S/D' }}</td>
                    <td>{{ $inoperativo->compania->compania ?? 'S/D' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" style="font-style: italic; text-align: center">SIN REGISTROS</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">
                    Total: {{ $datos->count() }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="firma">
        Emitido por: {{ auth()->user()->nombrecompleto ?? 'S/D' }}<br>
        @php
        $usuario = auth()->user();
            $letraCategoria = $usuario->categoria ? substr($usuario->categoria, 0, 1) : 'N/A';
            $codigo = $usuario->codigo ?? 'N/A';
        @endphp
        <small>{{ "$letraCategoria-$codigo" }}</small>
    </div>
@endsection

@push('styles')
@endpush
