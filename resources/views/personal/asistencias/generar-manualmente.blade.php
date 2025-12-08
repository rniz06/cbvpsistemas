@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Asistencias')
@section('content_header_title', 'Asistencias')
@section('content_header_subtitle', 'Generar Manualmente')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Mostrar un alert en caso de haber algun mensaje : SUCCESS O ERROR --}}
    @if ($msg = session('success') ?? session('error'))
        <x-adminlte-callout :icon="session('success') ? 'fas fa-check-circle' : 'fas fa-times'" :theme="session('success') ? 'success' : 'danger'" :title="$msg" :title-class="session('success') ? 'text-success' : 'text-danger'" />
    @endif
    
    {{-- Llamar al componente livewire para agregar un nuevo comisionamiento --}}
    @livewire('personal.asistencias.generar-manualmente')

@stop

@push('css')
    {{-- Incluir estilos adicionales desde el componente --}}
    @stack('styles')
@endpush

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
