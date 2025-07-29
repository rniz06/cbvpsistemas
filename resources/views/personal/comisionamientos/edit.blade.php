@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Personal')
@section('content_header_title', 'Personal')
@section('content_header_subtitle', 'Comisionamiento')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Llamar al componente livewire para editar un registro de comisionamiento --}}
    @livewire('personal.comisionamientos.edit', ['comisionamiento' => $comisionamiento])

@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
