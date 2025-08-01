@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'H. Herramientas - Marcas')
@section('content_header_title', 'Hidraulico - Herramientas - Marcas')
@section('content_header_subtitle', 'Listar')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Mostrar un alert en caso de haber algun mensaje --}}
    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5><i class="fas fa-check-circle mr-2" style="color: #28a745"></i>{{ $message }}</h5>
        </div>
    @endif

    {{-- Llamamos al componente livewire que renderiza el listado de Conductores --}}
    @livewire('materiales.equipo-hidraulico.herramientas.marcas')

@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
