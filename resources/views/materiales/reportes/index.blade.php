@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Reportes')
@section('content_header_title', 'Reportes')
@section('content_header_subtitle', 'Listar')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Mostrar un alert en caso de haber algun mensaje --}}
    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5><i class="fas fa-check-circle mr-2" style="color: #28a745"></i>{{ $message }}</h5>
        </div>
    @endif

    @can('Materiales Reportes Mayor General')
        <a class="btn btn-app" href="{{ route('materiales.reportes.mayor.general') }}">
            <i class="fas fa-th"></i> General
        </a>
    @endcan

    @can('Materiales Reportes Mayor Inoperativos')
        <a class="btn btn-app" href="{{ route('materiales.reportes.mayor.inoperativos') }}">
            <i class="fas fa-th"></i> Inoperativos
        </a>
    @endcan

@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
