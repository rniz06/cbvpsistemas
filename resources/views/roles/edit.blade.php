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

    <form class="p-2" action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card p-4">
            <div class="form-group">
                <label for="name">Nombre del Rol:</label>
                <input class="form-control" name="name" value="{{ $role->name }}" placeholder="Nombre del Rol" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
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
                                                                    {{ in_array($permiso->id, $rolePermissions) ? 'checked' : '' }}>
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

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Actualizar Rol</button>
        </div>
    </form>



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
