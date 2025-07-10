@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'CCA')
@section('content_header_title', 'CCA')
@section('content_header_subtitle', 'Despacho por Servicio Agregar Compañia')

{{-- Content body: main page content --}}

@section('content_body')
    @livewire('cca.despacho.despacho-por-servicio-add-compania', ['servicio' => $servicio])
@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
