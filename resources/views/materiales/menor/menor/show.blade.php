@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Mat. Menor')
@section('content_header_title', 'Menor')
@section('content_header_subtitle', 'Ver')

@section('content_body')
    {{-- MOSTRAR UN ALERT EN CASO DE HABER ALGUN MENSAJE : SUCCESS O ERROR --}}
    @if ($msg = session('success') ?? session('error'))
        <x-adminlte-callout :icon="session('success') ? 'fas fa-check-circle' : 'fas fa-times'" :theme="session('success') ? 'success' : 'danger'" :title="$msg" :title-class="session('success') ? 'text-success' : 'text-danger'" />
    @endif
    {{-- INCLUIR COMPONENTE LIVEWIRE DE PERSONAL --}}
    @livewire('materiales.menor.menor.show', ['menor' => $menor])
@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
