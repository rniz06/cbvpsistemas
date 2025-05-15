@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Roles')
@section('content_header_title', 'Roles')
@section('content_header_subtitle', 'Editar')

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

    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Editar Rol</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-body row">
                <div class="col-12 mb-3">
                    <label for="name">Nombre del Rol:</label>
                    <input class="form-control" name="name" value="{{ $role->name }}" placeholder="Nombre del Rol"
                        required>
                </div>

                <div class="col-12">
                    <label for="">Permisos:</label>
                    <div class="accordion" id="accordionModulos">
                        @foreach ($modulos as $modulo)
                            <div class="card">
                                <div class="card-header p-2" id="heading{{ $modulo->id_sys_modulo }}">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link font-weight-bold text-dark" type="button"
                                            data-toggle="collapse" data-target="#collapse{{ $modulo->id_sys_modulo }}"
                                            aria-expanded="true" aria-controls="collapse{{ $modulo->id_sys_modulo }}">
                                            {{ $modulo->modulo }}
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapse{{ $modulo->id_sys_modulo }}" class="collapse"
                                    aria-labelledby="heading{{ $modulo->id_sys_modulo }}" data-parent="#accordionModulos">
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($modulo->permissions as $permiso)
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="permission[{{ $permiso->id }}]"
                                                            value="{{ $permiso->id }}" id="permiso{{ $permiso->id }}"
                                                            {{ in_array($permiso->id, $rolePermissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permiso{{ $permiso->id }}">
                                                            {{ $permiso->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-warning">Guardar</button>
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
