@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'CCA')
@section('content_header_title', 'CCA')
@section('content_header_subtitle', 'Apoyos Activos')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Renderiza Tabla con apoyos activos --}}
    @livewire('cca.despacho.apoyos-activos')

@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
