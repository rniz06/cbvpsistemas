@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Personal')
@section('content_header_title', 'Personal')
@section('content_header_subtitle', 'Detalles')

{{-- Content body: main page content --}}

@section('content_body')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detalles del Personal</h3>
            <div class="card-tools">
                <a href="{{ route('personal.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i>
                    Volver</a>
                <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Actualizar</a>
                <a href="{{ route('personal.fichapdf', $personal->idpersonal) }}" class="btn btn-sm btn-success"><i
                        class="fas fa-file-export"></i> Exportar</a>
                <a href="#" class="btn btn-sm btn-dark"><i class="fas fa-plus"></i> Contacto</a>
                <a href="#" class="btn btn-sm btn-dark"><i class="fas fa-plus"></i> Emergencia</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    {{-- <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Estimated budget</span>
                                    <span class="info-box-number text-center text-muted mb-0">2300</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Total amount spent</span>
                                    <span class="info-box-number text-center text-muted mb-0">2000</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Estimated project duration</span>
                                    <span class="info-box-number text-center text-muted mb-0">20</span>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-6">
                            <label for="">Nombre Completo:</label>
                            <p class="form-control">{{ $personal->nombrecompleto ?? 'N/A' }}</p>
                        </div>

                        <div class="col-6">
                            <label for="">Codigo:</label>
                            <p class="form-control">{{ $personal->codigo ?? 'N/A' }}</p>
                        </div>

                        <div class="col-6">
                            <label for="">Documento:</label>
                            <p class="form-control">{{ $personal->documento ?? 'N/A' }}</p>
                        </div>

                        <div class="col-6">
                            <label for="">Fecha Juramento:</label>
                            <p class="form-control">{{ $personal->fecha_juramento ?? 'N/A' }}</p>
                        </div>

                        <div class="col-6">
                            <label for="">Categoría:</label>
                            <p class="form-control">{{ $personal->categoria ?? 'N/A' }}</p>
                        </div>

                        <div class="col-6">
                            <label for="">Estado:</label>
                            <p class="form-control">{{ $personal->estado ?? 'N/A' }}</p>
                        </div>

                        <div class="col-6">
                            <label for="">Pais:</label>
                            <p class="form-control">{{ $personal->pais ?? 'N/A' }}</p>
                        </div>

                        <div class="col-6">
                            <label for="">Sexo:</label>
                            <p class="form-control">{{ $personal->sexo ?? 'N/A' }}</p>
                        </div>

                        <div class="col-6">
                            <label for="">Grupo Sanguineo:</label>
                            <p class="form-control">{{ $personal->grupo_sanguineo ?? 'N/A' }}</p>
                        </div>

                        <div class="col-6">
                            <label for="">Compañia:</label>
                            <p class="form-control">{{ $personal->compania ?? 'N/A' }}</p>
                        </div>

                        <div class="col-6">
                            <label for="">Estado actualizar:</label>
                            <p class="form-control">{{ $personal->estado_actualizar ?? 'N/A' }}</p>
                        </div>

                        <div class="col-6">
                            <label for="">Ultima actualización:</label>
                            <p class="form-control">{{ date('d/m/Y', strtotime($personal->ultima_actualizacion)) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <h4 class="text-secondary"><i class="fas fa-address-book"></i> Contactos:</h4>
                    <ul class="list-unstyled">
                        <li>
                            @forelse ($contactos as $contacto)
                                <p class="btn-link text-secondary">{{ $contacto->tipo_contacto ?? 'N/A' }} :
                                    {{ $contacto->contacto ?? 'N/A' }}</p>
                            @empty
                                <p class="btn-link text-secondary">Sin datos...</p>
                            @endforelse
                        </li>
                    </ul>

                    <h4 class="text-secondary"><i class="fas fa-address-book"></i> Contactos de Emergencia:</h4>
                    <ul class="list-unstyled">
                        <li>
                            @forelse ($contactos_emergencias as $contacto_emergencia)
                                <p class="btn-link text-secondary">{{ $contacto_emergencia->parentesco ?? 'N/A' }} : {{ $contacto_emergencia->nombre_contacto ?? 'N/A' }}
                                    <br>
                                    {{ $contacto_emergencia->tipo_contacto ?? 'N/A' }} : {{ $contacto_emergencia->contacto ?? 'N/A' }}
                                </p>                                    
                            @empty
                                <p class="btn-link text-secondary">Sin datos...</p>
                            @endforelse
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    {{-- <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script> --}}
@endpush
