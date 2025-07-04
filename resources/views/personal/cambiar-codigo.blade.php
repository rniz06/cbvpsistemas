@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Personal')
@section('content_header_title', 'Personal')
@section('content_header_subtitle', 'Cambiar Codigo')

{{-- Content body: main page content --}}

@section('content_body')
    @livewire('personal.cambiar-codigo', ['personal' => $personal])
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Incluir estilos css adicionales desde el componente --}}
    @stack('css')
@endpush

{{-- Push extra scripts --}}

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
