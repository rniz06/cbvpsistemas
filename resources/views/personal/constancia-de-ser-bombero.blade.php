@extends('layouts.pdf.plantilla')

@section('titulo', 'Constancia de Registro')
@section('departamento', 'Departamento de Personal')

{{-- Definimos los logos para este reporte --}}
@php
    $logo_der = public_path('img/logos/cbvp-comandancia-logo.jpeg');
@endphp

@section('contenido')
    {{-- <h2
        style="background-color: #f2f2f2; border-radius: 24px; padding: 6px 10px; font-size: 11px; text-align: center; letter-spacing: 2px; font-weight: bold; margin-bottom: 5px;">
        D O C U M E N T O&nbsp;&nbsp;O F I C I A L&nbsp;&nbsp;D E&nbsp;&nbsp;A C R E D I T A C I Ó N
    </h2> --}}

    <div class="subtitulo" style="margin-top: 2rem;">CONSTANCIA DE REGISTRO</div>

    {{-- <p class="texto-centrado texto-chico" style="margin-top: 0.8rem;">
        Sistema Nacional de Bomberos (SINABOM)
    </p> --}}

    <p class="texto-justificado texto-chico" style="margin-top: 1rem;">
        El Cuerpo de Bomberos Voluntarios del Paraguay certifica que el/la voluntario/a
    </p>

    <p class="nombre-voluntario">
        {{ $personal->nombrecompleto ?? '' }}
    </p>

    <p class="texto-justificado texto-chico">
        se encuentra registrado/a activamente en los archivos institucionales con la ficha y datos filiatorios
        detallados a continuación:
    </p>

    <div class="subtitulo" style="margin-top: 1rem;">INFORMACIÓN PERSONAL Y REGISTRAL</div>

    <table class="tabla">
        <tbody class="tabla-tbody">
            <tr>
                <td class="col-25 bold">Código/Ficha</td>
                <td class="col-25">{{ $personal->codigo ?? '' }}</td>
                <td class="col-25 bold">N° Documento</td>
                <td class="col-25">{{ $personal->documento ?? '' }}</td>
            </tr>
            <tr>
                <td class="bold">Compañía</td>
                <td>{{ $personal->vtcompania->compania ?? '' }}</td>
                <td class="bold">Categoría</td>
                <td>{{ $personal->categoria->categoria ?? '' }}</td>
            </tr>
            <tr>
                <td class="bold">Fecha de Juramento</td>
                <td>
                    {{ !empty($personal->fecha_de_juramento) ? date('d/m/Y', strtotime($personal->fecha_de_juramento)) : '' }}
                    ({{ $personal->fecha_juramento ?? '' }})
                </td>
                <td class="bold">Estado Actual</td>
                <td>{{ $personal->estado->estado ?? '' }}</td>
            </tr>
            <tr>
                <td class="bold">Fecha Nacimiento</td>
                <td>{{ $personal->fecha_nacimiento ?? '' }}</td>
                <td class="bold">Sexo</td>
                <td>{{ $personal->sexo->sexo ?? '' }}</td>
            </tr>
            <tr>
                <td class="bold">Grupo Sanguíneo</td>
                <td>{{ $personal->grupoSanguineo->grupo_sanguineo ?? '' }}</td>
                <td class="bold"></td>
                <td></td>
                {{-- <td class="bold">Nacionalidad</td>
                <td>{{ $personal->nacionalidad->grupo_sanguineo ?? '' }}</td> --}}
            </tr>
        </tbody>
    </table>

    <p class="texto-centrado texto-pie">
        @if ($personal->ultima_actualizacion)
            Última Actualización del Registro: {{ !empty($personal->ultima_actualizacion) ? date('d/m/Y', strtotime($personal->ultima_actualizacion)) : '' }}
        @endif
    </p>

    {{-- Sección de Firmas --}}
    <table class="tabla-firmas">
        <tr>
            <td>
                <div class="linea-firma"></div>
                <strong>Comandancia</strong><br>
                <small>Cuerpo de Bomberos Voluntarios del Paraguay</small>
            </td>
            <td>
                <div class="linea-firma"></div>
                <strong>Dpto. de Personal</strong><br>
                <small>Comandancia Nacional - CBVP</small>
            </td>
        </tr>
    </table>

    <p class="texto-centrado texto-pie-pagina">
        Departamento de TI a través del Sistema Nacional de Bomberos | https://sinabom.cbvp.org.py
    </p>
@endsection

@push('styles')
    <style>
        .titulo-oficial {
            text-align: center;
            letter-spacing: 3px;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .texto-centrado {
            text-align: center;
        }

        .texto-justificado {
            text-align: justify;
        }

        .texto-chico {
            font-size: 11px;
            font-style: italic;
            text-align: center;
            color: #777;
        }

        .bold {
            font-weight: bold;
        }

        .col-25 {
            width: 25%;
        }

        .nombre-voluntario {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin: 0.5rem 0;
        }

        .texto-pie {
            text-align: center;
            font-size: 10px;
            margin-top: 0.8rem;
            color: #555;
        }

        .texto-pie-pagina {
            text-align: center;
            font-size: 9px;
            margin-top: 1.5rem;
            color: #777;
        }

        .tabla-firmas {
            width: 100%;
            margin-top: 3rem;
            border: collapse;
        }

        .tabla-firmas td {
            width: 50%;
            text-align: center;
            border: none !important;
        }

        .linea-firma {
            width: 80%;
            margin: 0 auto 5px auto;
            border-top: 1px solid #000;
        }
    </style>
@endpush
