@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Aspirantes')
@section('content_header_title', 'Aspirantes')
@section('content_header_subtitle', 'Aspirantes')

{{-- Content body: main page content --}}

@section('content_body')
    @livewire('ANB.ECB.Aspirantes.index')
@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
