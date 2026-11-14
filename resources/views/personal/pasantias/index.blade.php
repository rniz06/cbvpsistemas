
@extends('layouts.app')

@section('subtitle', 'Pasantías')
@section('content_header_title', 'Personal')
@section('content_header_subtitle', 'Pasantías')

@section('content_body')
    @livewire('personal.pasantias.index')
@stop

@push('css')
    @stack('styles')
@endpush

@push('js')
    @stack('scripts')
@endpush
