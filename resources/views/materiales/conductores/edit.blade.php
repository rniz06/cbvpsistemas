@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Conductores')
@section('content_header_title', 'Conductores')
@section('content_header_subtitle', 'Actualizar')

{{-- Content body: main page content --}}

@section('content_body')

    @livewire('materiales.conductores.edit', ['conductor' => $conductor])

@stop

@push('css')
@endpush

@push('js')
@endpush
