@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Llamados')
@section('content_header_title', 'Llamados')
@section('content_header_subtitle', 'Llamados')

{{-- Content body: main page content --}}

@section('content_body')
    @livewire('ANB.ECB.Llamados.index')
@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
