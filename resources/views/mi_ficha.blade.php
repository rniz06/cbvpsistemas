@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Mi Ficha')
@section('content_header_title', 'Mi Ficha')
@section('content_header_subtitle', 'Ver')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-warning card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('img/cbvp-logo.webp') }}"
                            alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $personal->nombrecompleto ?? 'N/A' }}</h3>

                    <p class="text-muted text-center">{{ $personal->categoria ?? 'N/A' }} - {{ $personal->codigo ?? 'N/A' }}
                        - {{ $personal->compania ?? 'N/A' }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Servicios</b> <a class="float-right text-dark badge badge-warning">...</a>
                        </li>
                        <li class="list-group-item">
                            <b>Resoluciones</b> <a class="float-right text-dark badge badge-warning">{{ $resoluciones->total() ?? '000' }}</a>
                        </li>
                        {{-- <li class="list-group-item">
                            <b>Friends</b> <a class="float-right">13,287</a>
                        </li> --}}
                    </ul>

                    {{-- <a href="#" class="btn btn-warning btn-block"><b>Follow</b></a> --}}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Mis Datos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @forelse ($personalContactos as $personalContacto)
                        <strong><i class="fas fa-info mr-1"></i>
                            {{ $personalContacto->tipo_contacto ?? 'N/A' }}</strong>

                        <p class="text-muted">
                            {{ $personalContacto->contacto ?? 'N/A' }}
                        </p>

                        <hr>
                    @empty
                        <p class="text-muted">
                            Sin datos de contactos...
                        </p>
                    @endforelse

                    @forelse ($personalContactosEmergencias as $personalContactosEmergencia)
                        <strong><i class="fas fa-info mr-1"></i>
                            {{ $personalContactosEmergencia->nombre_contacto ?? 'N/A' }} -
                            {{ $personalContactosEmergencia->parentesco ?? 'N/A' }}</strong>

                        <p class="text-muted">
                            {{ $personalContactosEmergencia->tipo_contacto ?? 'N/A' }} :
                            {{ $personalContactosEmergencia->contacto ?? 'N/A' }}
                            <br>
                            {{ $personalContactosEmergencia->ciudad ?? 'N/A' }} :
                            {{ $personalContactosEmergencia->direccion ?? 'N/A' }}
                        </p>

                        <hr>
                    @empty
                        <p class="text-muted">
                            Sin datos de contactos de emergencia...
                        </p>
                    @endforelse

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#mis_resoluciones" data-toggle="tab">Mis
                                resoluciones</a></li>
                        <li class="nav-item"><a class="nav-link" href="#mis_servicios" data-toggle="tab">Mis Servicios</a></li>
                        {{-- <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li> --}}
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="table-responsive active tab-pane" id="mis_resoluciones">
                            <table class="table table-striped table-bordered table-sm p-0">
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
                                            <td><a href="http://resoluciones.cbvp.org.py/descargar-resolucion/{{ $resolucion->id_resolucion }}"
                                                    target="_blank" class="btn btn-sm btn-success"><i
                                                        class="fas fa-file-pdf"></i></a></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Sin resoluciones asignadas...</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $resoluciones->links('pagination::bootstrap-4') }}
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="mis_servicios">
                            <!-- The timeline -->
                            {{-- <div class="timeline timeline-inverse">
                                <!-- timeline time label -->
                                <div class="time-label">
                                    <span class="bg-danger">
                                        10 Feb. 2014
                                    </span>
                                </div>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <div>
                                    <i class="fas fa-envelope bg-primary"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email
                                        </h3>

                                        <div class="timeline-body">
                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                            quora plaxo ideeli hulu weebly balihoo...
                                        </div>
                                        <div class="timeline-footer">
                                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <div>
                                    <i class="fas fa-user bg-info"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                                        <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted
                                            your friend request
                                        </h3>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <div>
                                    <i class="fas fa-comments bg-warning"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post
                                        </h3>

                                        <div class="timeline-body">
                                            Take me to your leader!
                                            Switzerland is small and neutral!
                                            We are more like Germany, ambitious and misunderstood!
                                        </div>
                                        <div class="timeline-footer">
                                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <!-- timeline time label -->
                                <div class="time-label">
                                    <span class="bg-success">
                                        3 Jan. 2014
                                    </span>
                                </div>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <div>
                                    <i class="fas fa-camera bg-purple"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos
                                        </h3>

                                        <div class="timeline-body">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                        </div>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <div>
                                    <i class="far fa-clock bg-gray"></i>
                                </div>
                            </div> --}}
                            <p class="font-weight-bold font-italic text-center">Proximamente tus estadisticas de servicio...</p>
                        </div>
                        <!-- /.tab-pane -->

                        {{-- <div class="tab-pane" id="settings">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputSkills"
                                            placeholder="Skills">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> I agree to the <a href="#">terms and
                                                    conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div> --}}
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
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
