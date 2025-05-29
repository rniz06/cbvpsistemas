@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Permisos')
@section('content_header_title', 'Permisos')
@section('content_header_subtitle', 'Asignar Permisos a Usuario')

{{-- Content body: main page content --}}

@section('content_body')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Hubo algunos problemas con tu entrada.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Asignar permisos especificos a usuario</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body row">
            <div class="col-3">
                <label for="">Nombre Completo:</label>
                <p class="form-control">{{ $usuario->nombrecompleto ?? 'N/A' }}</p>
            </div>
            <div class="col-3">
                <label for="">Codigo:</label>
                <p class="form-control">{{ $usuario->codigo ?? 'N/A' }}</p>
            </div>
            <div class="col-3">
                <label for="">Documento:</label>
                <p class="form-control">{{ $usuario->documento ?? 'N/A' }}</p>
            </div>
            <div class="col-3">
                <label for="">Compañia:</label>
                <p class="form-control">{{ $usuario->compania ?? 'N/A' }}</p>
            </div>
        </div>
        <form action="{{ route('usuarios.asignarpermiso', $usuario->id_usuario) }}" method="POST">
            @csrf
            @method('post')
            <div class="card-body row">
                <div class="col-12">
                    <label for="">Permisos:</label>
                    <div class="accordion" id="accordionModulos">
                        @foreach ($modulos as $modulo)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Módulo: {{ $modulo->modulo }}</h3>
                        </div>
                        <div class="card-body">
                            @foreach ($modulo->subModulos as $submodulo)
                                @if ($submodulo->permissions->count() > 0)
                                    <div id="accordion-{{ $submodulo->id_sub_modulo }}">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a class="d-block w-100" data-toggle="collapse"
                                                        href="#collapse-{{ $submodulo->id_sub_modulo }}">
                                                        {{ $submodulo->sub_modulo ?? 'N/A' }}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapse-{{ $submodulo->id_sub_modulo }}" class="collapse"
                                                data-parent="#accordion-{{ $submodulo->id_sub_modulo }}">
                                                <div class="card-body row">
                                                    @foreach ($submodulo->permissions as $permiso)
                                                        <div class="col-md-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="permission[{{ $permiso->id }}]"
                                                                    value="{{ $permiso->id }}"
                                                                    id="permiso{{ $permiso->id }}"
                                                                    {{ in_array($permiso->id, $userPermiso) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="permiso{{ $permiso->id }}">
                                                                    {{ $permiso->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary float-right"><i
                        class="fas fa-arrow-left"></i>
                    Volver</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>

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
