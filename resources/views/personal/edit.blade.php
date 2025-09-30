@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Personal')
@section('content_header_title', 'Personal')
@section('content_header_subtitle', 'Editar Ficha')

{{-- Content body: main page content --}}

@section('content_body')

    @livewire('personal.edit', ['personal' => $personal])

@stop

@push('css')
@endpush

@push('js')
@endpush
