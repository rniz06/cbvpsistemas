@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Usuarios')
@section('content_header_title', 'Usuarios')
@section('content_header_subtitle', 'Asignar Roles')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Mostrar un alert en caso de haber algun mensaje --}}
    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5><i class="fas fa-check-circle mr-2" style="color: #28a745"></i>{{ $message }}</h5>
        </div>
    @endif
    @livewire('usuarios.asignar-rol', ['usuario' => $usuario->id_usuario])

@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
