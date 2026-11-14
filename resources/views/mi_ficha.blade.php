
@extends('layouts.app')

@section('subtitle', 'Mi Ficha')
@section('content_header_title', 'Mi Ficha')
@section('content_header_subtitle', 'Ver')

@section('content_body')
    <div class="row">
        <div class="col-md-3">

            {{-- PERFIL --}}
            <div class="card card-warning card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img
                            class="profile-user-img img-fluid img-circle"
                            src="{{ asset('img/cbvp-logo.webp') }}"
                            alt="User profile picture"
                        >
                    </div>

                    <h3 class="profile-username text-center">
                        {{ $personal->nombrecompleto ?? 'N/A' }}
                    </h3>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Servicios</b>
                            <a class="float-right text-dark badge badge-warning">...</a>
                        </li>

                        <li class="list-group-item">
                            <b>Resoluciones</b>
                            <a class="float-right text-dark badge badge-warning">
                                {{ $resoluciones->total() ?? '000' }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- DATOS PERSONALES --}}
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Mis Datos</h3>
                </div>

                <div class="card-body">
                    <p>
                        <strong>Código: </strong>
                        {{ $personal->codigo ?? 'No Registra' }}
                    </p>

                    <p>
                        <strong>Documento: </strong>
                        {{ $personal->documento ?? 'No Registra' }}
                    </p>

                    <p>
                        <strong>Categoría: </strong>
                        {{ $personal->categoria ?? 'No Registra' }}
                    </p>

                    <p>
                        <strong>Compañía: </strong>
                        {{ $personal->compania ?? 'No Registra' }}
                    </p>

                    <p>
                        <strong>Fecha de Juramento: </strong>
                        {{ $personal->fecha_de_juramento ?? 'No Registra' }}
                    </p>

                    <p>
                        <strong>Año de Juramento: </strong>
                        {{ $personal->fecha_juramento ?? 'No Registra' }}
                    </p>

                    <p>
                        <strong>Estado: </strong>
                        {{ $personal->estado ?? 'No Registra' }}
                    </p>

                    <p>
                        <strong>Sexo: </strong>
                        {{ $personal->sexo ?? 'No Registra' }}
                    </p>

                    <p>
                        <strong>Nacionalidad: </strong>
                        {{ $personal->pais ?? 'No Registra' }}
                    </p>

                    <p>
                        <strong>G. Sanguíneo: </strong>
                        {{ $personal->grupo_sanguineo ?? 'No Registra' }}
                    </p>

                    <hr>

                    @forelse ($personalContactos as $personalContacto)
                        <strong>
                            <i class="fas fa-info mr-1"></i>
                            {{ $personalContacto->tipo_contacto ?? 'N/A' }}
                        </strong>

                        <p class="text-muted">
                            {{ $personalContacto->contacto ?? 'N/A' }}
                        </p>

                        <hr>
                    @empty
                        <p class="text-muted">Sin datos de contactos...</p>
                    @endforelse

                    @forelse ($personalContactosEmergencias as $personalContactosEmergencia)
                        <strong>
                            <i class="fas fa-info mr-1"></i>
                            {{ $personalContactosEmergencia->nombre_contacto ?? 'N/A' }}
                            -
                            {{ $personalContactosEmergencia->parentesco ?? 'N/A' }}
                        </strong>

                        <p class="text-muted">
                            {{ $personalContactosEmergencia->tipo_contacto ?? 'N/A' }}:
                            {{ $personalContactosEmergencia->contacto ?? 'N/A' }}
                            <br>
                            {{ $personalContactosEmergencia->ciudad ?? 'N/A' }}:
                            {{ $personalContactosEmergencia->direccion ?? 'N/A' }}
                        </p>

                        <hr>
                    @empty
                        <p class="text-muted">
                            Sin datos de contactos de emergencia...
                        </p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- PESTAÑAS --}}
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">

                        {{-- PRIMERA PESTAÑA --}}
                        <li class="nav-item">
                            <a
                                class="nav-link active"
                                href="#mi_porcentaje"
                                data-toggle="tab"
                            >
                                <i class="fas fa-percentage"></i>
                                Mi porcentaje
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#mis_resoluciones"
                                data-toggle="tab"
                            >
                                Mis resoluciones
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#mis_comisionamientos"
                                data-toggle="tab"
                            >
                                Mis comisionamientos
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="#mis_servicios"
                                data-toggle="tab"
                            >
                                Mis servicios
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">

                        {{-- MI PORCENTAJE --}}
                        <div
                            class="active tab-pane"
                            id="mi_porcentaje"
                        >
                            @livewire('perfil.mi-porcentaje')
                        </div>

                        {{-- MIS RESOLUCIONES --}}
                        <div
                            class="tab-pane"
                            id="mis_resoluciones"
                        >
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>N° Resolución</th>
                                            <th>Concepto</th>
                                            <th>Fecha</th>
                                            <th>Origen</th>
                                            <th style="width: 40px">Descargar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($resoluciones as $resolucion)
                                            <tr>
                                                <td>
                                                    {{ $resolucion->n_resolucion ?? 'N/A' }}
                                                </td>

                                                <td>
                                                    {{ $resolucion->concepto ?? 'N/A' }}
                                                </td>

                                                <td>
                                                    {{ $resolucion->fecha
                                                        ? date('d/m/Y', strtotime($resolucion->fecha))
                                                        : 'N/A' }}
                                                </td>

                                                <td>
                                                    {{ $resolucion->fuente_origen ?? 'N/A' }}
                                                </td>

                                                <td>
                                                    <a
                                                        href="https://resoluciones.cbvp.org.py/descargar-resolucion/{{ $resolucion->id_resolucion }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="btn btn-sm btn-success"
                                                    >
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    Sin resoluciones asignadas...
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{ $resoluciones->links('pagination::bootstrap-4') }}
                        </div>

                        {{-- MIS COMISIONAMIENTOS --}}
                        <div
                            class="tab-pane"
                            id="mis_comisionamientos"
                        >
                            @livewire('perfil.mis-comisionamientos')
                        </div>

                        {{-- MIS SERVICIOS --}}
                        <div
                            class="tab-pane"
                            id="mis_servicios"
                        >
                            @livewire('perfil.mis-servicios')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
@endpush

@push('js')
@endpush
