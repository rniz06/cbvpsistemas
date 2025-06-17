@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Inicio')
@section('content_header_title', 'Inicio')
@section('content_header_subtitle', 'Bienvenida')

{{-- Content body: main page content --}}

@section('content_body')

    <div class="row">
        <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">
                <!-- timeline time label -->
                <div class="time-label">
                    <span class="bg-warning">@php
                        echo date('d M. Y');
                    @endphp</span>
                </div>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                {{-- <div>
                    <i class="fas fa-info bg-blue"></i>
                    <div class="timeline-item">
                        <h3 class="timeline-header font-weight-bold">Sessiones de Directorio Nacional En Vivo</h3>

                        <div class="timeline-body">
                            <p>¡Hola! Te damos la bienvenida a la plataforma de sesiones en vivo del Directorio Nacional. Aquí podrás
                                acceder a las sesiones en vivo y ver los videos de sesiones pasadas.</p>
                        </div>
                    </div>
                </div> --}}
                <!-- END timeline item -->
                <!-- timeline item -->
                <div>
                    <i class="fas fa-video bg-maroon"></i>

                    <div class="timeline-item">
                        {{-- <span class="time"><i class="fas fa-clock"></i> 5 days ago</span> --}}

                        <h3 class="timeline-header">¡Hola! Te damos la bienvenida a la plataforma de sesiones en vivo del Directorio Nacional. Aquí podrás acceder a las sesiones en vivo y ver los videos de sesiones pasadas.</h3>

                        <div class="timeline-body">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/jz9ZaJz6FOA"
                                    allowfullscreen=""></iframe>
                            </div>
                        </div>
                        {{-- <div class="timeline-footer">
                            <a href="#" class="btn btn-sm bg-maroon">See comments</a>
                        </div> --}}
                    </div>
                </div>
                <!-- END timeline item -->
                <div>
                    <i class="fas fa-window-minimize bg-gray"></i>
                </div>
            </div>
        </div>
        <!-- /.col -->
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
