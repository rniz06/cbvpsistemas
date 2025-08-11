@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Cargos')
@section('content_header_title', 'Cargos')
@section('content_header_subtitle', 'Listar')

{{-- Content body: main page content --}}

@section('content_body')
    {{-- Llamamos al componente livewire que renderiza el listado de cargos --}}
    @livewire('personal.cargos.index')
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