@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'CCA')
@section('content_header_title', 'CCA')
@section('content_header_subtitle', 'Ver Servicio')

{{-- Content body: main page content --}}

@section('content_body')
    {{-- MOSTRAR UN ALERT EN CASO DE HABER ALGUN MENSAJE : SUCCESS O ERROR --}}
    @if ($msg = session('success') ?? session('error'))
        <x-adminlte-callout :icon="session('success') ? 'fas fa-check-circle' : 'fas fa-times'" :theme="session('success') ? 'success' : 'danger'" :title="$msg" :title-class="session('success') ? 'text-success' : 'text-danger'" />
    @endif

    {{-- Renderiza Ficha del Servicio --}}
    @livewire('cca.despacho.ver-servicio', ['servicio' => $servicio])

    {{-- Renderiza Comentarios del Servicio --}}
    @livewire('cca.despacho.comentarios', ['servicio' => $servicio])

    {{-- Renderiza Apoyos del Servicio --}}
    @livewire('cca.despacho.apoyos', ['servicio' => $servicio])
@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
