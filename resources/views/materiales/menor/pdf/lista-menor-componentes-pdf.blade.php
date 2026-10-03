@extends('layouts.pdf.plantilla')

{{-- @section('titulo', 'TITULO') --}}

@section('departamento', 'Departamento de Matenimiento de Materiales')

{{-- Definimos los logos para este reporte --}}
@php
    $logo_der = public_path('img/logos/dmm-logo.webp');
@endphp


@section('contenido')
    {{-- <h2 style="text-align: center">Mayor</h2> --}}

    <div class="subtitulo" style="margin-top: 1rem">{{ $subtitulo ?? 'LISTA DE COMPONENTES' }}</div>

    <table class="tabla">
        <thead class="tabla-thead">
            <tr>
                <th style="width: 10px">#</th>
                <th>Nombre</th>
                <th>Componente de</th>
                <th>Categoria</th>
            </tr>
        </thead>

        <tbody class="tabla-tbody">
            @forelse ($datos as $componente)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $componente->nombre ?? 'S/D' }}</td>
                    <td>{{ $componente->tipo->tipo ?? 'S/D' }}</td>
                    <td>{{ $componente->categoria->nombre ?? 'S/D' }}</td>
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
