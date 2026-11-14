
@extends('layouts.app')

@section('subtitle', 'Personal')
@section('content_header_title', 'Personal')
@section('content_header_subtitle', 'Enlazar Código')

@section('content_body')
    @livewire('personal.enlazar-codigo', [
        'personalId' => (int) $personal
    ])
@stop

@push('css')
    @stack('css')
@endpush

@push('js')
    @stack('scripts')
@endpush
