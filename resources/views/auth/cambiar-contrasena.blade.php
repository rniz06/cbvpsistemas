@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Cambiar Contraseña')
@section('content_header_title', 'Inicio')
@section('content_header_subtitle', 'Cambiar Contraseña')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Actualizar Contraseña</div>

                    <form action="{{ route('actualizar-contrasena') }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="oldPasswordInput" class="form-label">Contraseña Antigua</label>
                                <input name="old_password" type="password"
                                    class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                                    placeholder="Contraseña Antigua...">
                                @error('old_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="newPasswordInput" class="form-label">Nueva Contraseña</label>
                                <input name="new_password" type="password"
                                    class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                    placeholder="Nueva Contraseña...">
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="confirmNewPasswordInput" class="form-label">Confirmar Nueva Contraseña</label>
                                <input name="new_password_confirmation" type="password" class="form-control"
                                    id="confirmNewPasswordInput" placeholder="Confirmar Nueva Contraseña...">
                            </div>

                        </div>

                        <div class="card-footer">
                            <button class="btn btn-success">Actualizar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
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
