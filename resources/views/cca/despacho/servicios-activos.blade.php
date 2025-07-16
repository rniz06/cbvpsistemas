@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'CCA')
@section('content_header_title', 'CCA')
@section('content_header_subtitle', 'Servicios Activos')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Renderiza Ficha del Servicio --}}
    @livewire('cca.despacho.servicios-activos')

    {{-- Renderiza Comentarios del Servicio --}}
    {{-- @livewire('cca.despacho.comentarios', ['servicio' => $servicio]) --}}

    {{-- Renderiza Apoyos del Servicio --}}
    {{-- @livewire('cca.despacho.apoyos', ['servicio' => $servicio]) --}}
@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
