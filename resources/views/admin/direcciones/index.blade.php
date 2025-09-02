@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Direcciones')
@section('content_header_title', 'Direcciones')
@section('content_header_subtitle', 'Listar')

{{-- Content body: main page content --}}

@section('content_body')
    {{-- Llamamos a los componentes livewire que renderizan el formulario y listado de direcciones --}}
    @livewire('admin.direcciones.form')
    @livewire('admin.direcciones.index')
@stop

{{-- @section('plugins.Datatables', true) --}}
{{-- Push extra CSS --}}

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush