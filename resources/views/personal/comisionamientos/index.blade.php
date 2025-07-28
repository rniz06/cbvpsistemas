@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Comisionamientos')
@section('content_header_title', 'Comisionamientos')
@section('content_header_subtitle', 'Listar')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Llamar al componente livewire para agregar un nuevo comisionamiento --}}
    {{-- @livewire('personal.comisionamientos.create', ['personal' => $personal]) --}}
    <h4>vista con tabla de comisionamientos</h4>
    <br>
    <a href="{{ route('personal.comisionamientos.create') }}" class="btn-btn-success btn-sm">Agregar Comisionamiento</a>

@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
