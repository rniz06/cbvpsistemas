@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Personal')
@section('content_header_title', 'Personal')
@section('content_header_subtitle', 'Detalles')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Mostrar un alert en caso de haber algun mensaje --}}
    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5><i class="fas fa-check-circle mr-2" style="color: #28a745"></i>{{ $message }}</h5>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detalles del Personal</h3>
            <div class="card-tools">
                <a href="{{ route('personal.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i>
                    Volver</a>
                @can('Personal Editar')
                    <a href="{{ route('personal.edit', $personal->idpersonal) }}" class="btn btn-sm btn-warning"><i
                            class="fas fa-edit"></i> Actualizar</a>
                @endcan
                @can('Personal Generar Ficha')
                    <a href="{{ route('personal.fichapdf', $personal->idpersonal) }}" class="btn btn-sm btn-success"><i
                            class="fas fa-file-export"></i> Exportar</a>
                @endcan
                @can('Personal Agregar Contacto')
                    <!-- Button Modal Contacto -->
                    <button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#staticBackdrop">
                        <i class="fas fa-plus"></i> Contacto
                    </button>
                @endcan
                @can('Personal Agregar Contacto Emergencia')
                    <!-- Button Modal Contacto Emergencia -->
                    <button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#contactoemergencia">
                        <i class="fas fa-plus"></i> Emergencia
                    </button>
                @endcan
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
                                <p class="btn-link text-secondary">{{ $contacto_emergencia->parentesco ?? 'N/A' }} :
                                    {{ $contacto_emergencia->nombre_contacto ?? 'N/A' }}
                                    <br>
                                    {{ $contacto_emergencia->tipo_contacto ?? 'N/A' }} :
                                    {{ $contacto_emergencia->contacto ?? 'N/A' }}
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

        <!-- Modal add contacto -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Agregar Contacto de Personal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('personal.agregarcontacto') }}" method="post">
                            @csrf
                            @method('POST')

                            <input type="hidden" name="personal_id" value="{{ $personal->idpersonal }}">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tipo de Contacto:</label>
                                <select class="form-control" required name="tipo_contacto_id">
                                    <option>Seleccionar...</option>
                                    @foreach ($tipo_contactos as $tipo_contacto)
                                        <option value="{{ $tipo_contacto->id_tipo_contacto }}">
                                            {{ $tipo_contacto->tipo_contacto }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Contacto:</label>
                                <input type="text" name="contacto" class="form-control" id="exampleInputEmail1"
                                    placeholder="Contacto..." required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i
                                        class="fas fa-arrow-left"></i> Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>
                                    Guardar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal add contacto emergencia -->
        <div class="modal fade" id="contactoemergencia" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Agregar Contacto de Emergencia</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('personal.agregarcontactoemergencia') }}" method="post">
                            @csrf
                            @method('POST')

                            <input type="hidden" name="personal_id" value="{{ $personal->idpersonal }}">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tipo de Contacto:</label>
                                <select class="form-control" required name="tipo_contacto_id">
                                    <option>Seleccionar...</option>
                                    @foreach ($tipo_contactos as $tipo_contacto)
                                        <option value="{{ $tipo_contacto->id_tipo_contacto }}">
                                            {{ $tipo_contacto->tipo_contacto }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Parentesco:</label>
                                <select class="form-control" required name="parentesco_id">
                                    <option>Seleccionar...</option>
                                    @foreach ($parentescos as $parentesco)
                                        <option value="{{ $parentesco->id_parentesco }}">
                                            {{ $parentesco->parentesco }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Ciudad:</label>
                                <select class="js-example-basic-single" name="ciudad_id" required style="width: 100%">
                                    <option value="">Seleccionar...</option>
                                    @foreach ($ciudades as $ciudad)
                                        <option value="{{ $ciudad->idciudades }}">{{ $ciudad->ciudad ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre Completo:</label>
                                <input type="text" name="nombre_completo" class="form-control"
                                    id="exampleInputEmail1" placeholder="Nombre Completo..." required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Dirección:</label>
                                <input type="text" name="direccion" class="form-control" id="exampleInputEmail1"
                                    placeholder="Direccion...">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Contacto:</label>
                                <input type="text" name="contacto" class="form-control" id="exampleInputEmail1"
                                    placeholder="Contacto..." required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i
                                        class="fas fa-arrow-left"></i> Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>
                                    Guardar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Resoluciones</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>N° Resolucion:</th>
                        <th>Concepto:</th>
                        <th>Fecha:</th>
                        <th>Origen:</th>
                        <th style="width: 40px">Descargar:</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($resoluciones as $resolucion)
                        <tr>
                            <td>#</td>
                            <td>{{ $resolucion->n_resolucion ?? 'N/A' }}</td>
                            <td>{{ $resolucion->concepto ?? 'N/A' }}</td>
                            <td>{{ date('d/m/Y', strtotime($resolucion->fecha)) ?? 'N/A' }}</td>
                            <td>{{ $resolucion->fuente_origen ?? 'N/A' }}</td>
                            <td><a href="http://resoluciones.cbvp.org.py/descargar-resolucion/{{ $resolucion->id_resolucion }}" target="_blank"
                                    class="btn btn-sm btn-success"><i class="fas fa-file-pdf"></i></a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Sin datos...</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        {{-- <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                <li class="page-item"><a class="page-link" href="#">«</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">»</a></li>
            </ul>
        </div> --}}
    </div>
@stop

@section('plugins.Select2', true)

{{-- Push extra CSS --}}

@push('css')
    <style>
        /* Corrige estilos del select2 */
        .selection span {
            height: 38px !important;
        }
    </style>
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                dropdownParent: $('#contactoemergencia'),
                placeholder: 'Seleccionar...',
                language: "es",

            });
        });
    </script>
@endpush
