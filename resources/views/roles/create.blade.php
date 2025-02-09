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

    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Añadir Rol</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            @method('post')
            <div class="card-body row">
                <div class="col-12">
                    <label for="">Nombre Completo:</label>
                    <input class="form-control" name="name" placeholder="Nombre del Rol" required>
                </div>

                <div class="col-12">
                    <label for="">Permisos:</label><br>
                    @foreach ($permisos as $value)
                        <label><input type="checkbox" name="permission[{{ $value->id }}]" value="{{ $value->id }}"
                                class="name">
                            {{ $value->name }}</label>
                        <br />
                    @endforeach
                </div>


            </div>
            <!-- /.card-body -->

            <div class="card-footer">
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
