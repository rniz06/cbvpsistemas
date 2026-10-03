@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Examenes')
@section('content_header_title', 'Examenes')
@section('content_header_subtitle', 'Examenes')

{{-- Content body: main page content --}}

@section('content_body')
    @livewire('ANB.ECB.Examenes-fisicos.index')
@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
