@extends('layouts.app')

@section('subtitle', 'Rectificaciones')
@section('content_header_title', 'Asistencias')
@section('content_header_subtitle', 'Rectificaciones')

@section('content_body')

    @livewire('personal.asistencias.rectificaciones')

@stop

@push('css')
    @stack('styles')
@endpush

@push('js')
    @stack('scripts')
@endpush