@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Roles')
@section('content_header_title', 'Roles')
@section('content_header_subtitle', 'Crear')

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

    <form class="p-2" action="{{ route('roles.store') }}" method="POST">
        @csrf
        @method('post')
        <div class="card p-4">
            <div class="form-group">
                <label for="name">Nombre del Rol:</label>
                <input class="form-control" name="name" placeholder="Nombre del Rol" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @foreach ($modulos as $modulo)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Modulo: {{ $modulo->modulo }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
                            @foreach ($modulo->subModulos as $submodulo)
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
                                                @forelse ($submodulo->permissions as $permiso)
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="permission[{{ $permiso->id }}]"
                                                                value="{{ $permiso->id }}"
                                                                id="permiso{{ $permiso->id }}">
                                                            <label class="form-check-label"
                                                                for="permiso{{ $permiso->id }}">
                                                                {{ $permiso->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <p class="text-muted ml-3">No hay permisos registrados.</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- /.card-body -->
                    </div>
                @endforeach
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
        </div>
    </form>


    {{-- <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Añadir Rol</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            @method('post')
            <div class="card-body row">
                <div class="col-12 mb-3">
                    <label for="name">Nombre del Rol:</label>
                    <input class="form-control" name="name" placeholder="Nombre del Rol" required>
                </div>

                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Modulo</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
                            <div id="accordion">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h4 class="card-title w-100">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseOne"
                                                aria-expanded="true">
                                                Collapsible Group Item #1
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordion" style="">
                                        <div class="card-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                            richardson ad squid.
                                            3
                                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa
                                            nesciunt
                                            laborum
                                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
                                            single-origin
                                            coffee
                                            nulla
                                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                                            anderson cred
                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                                            occaecat craft
                                            beer
                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of
                                            them
                                            accusamus
                                            labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h4 class="card-title w-100">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                                                Collapsible Group Danger
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                            richardson ad squid.
                                            3
                                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa
                                            nesciunt
                                            laborum
                                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
                                            single-origin
                                            coffee
                                            nulla
                                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                                            anderson cred
                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                                            occaecat craft
                                            beer
                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of
                                            them
                                            accusamus
                                            labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h4 class="card-title w-100">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                                                Collapsible Group Success
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                            richardson ad squid.
                                            3
                                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa
                                            nesciunt
                                            laborum
                                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
                                            single-origin
                                            coffee
                                            nulla
                                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                                            anderson cred
                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                                            occaecat craft
                                            beer
                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of
                                            them
                                            accusamus
                                            labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <div class="col-12">
                    <label for="">Permisos:</label>
                    <div class="accordion" id="accordionModulos">
                        @foreach ($modulos as $modulo)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button ...>
                                        {{ $modulo->modulo }}
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        @foreach ($modulo->subModulos as $submodulo)
                                            <div class="card mb-2">
                                                <div class="card-header">
                                                    {{ $submodulo->sub_modulo }}
                                                </div>
                                                <div class="card-body">
                                                    @foreach ($submodulo->permissions as $permiso)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="permission[{{ $permiso->id }}]"
                                                                value="{{ $permiso->id }}" id="permiso{{ $permiso->id }}"
                                                                {{ in_array($permiso->id, $rolePermissions ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="permiso{{ $permiso->id }}">
                                                                {{ $permiso->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>

    </div> --}}


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
