@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Cca Operatividad')
@section('content_header_title', 'Cca Operatividad')
@section('content_header_subtitle', 'Listar')

{{-- Content body: main page content --}}

@section('content_body')
    {{-- MOSTRAR UN ALERT EN CASO DE HABER ALGUN MENSAJE : SUCCESS O ERROR --}}
    @if ($msg = session('success') ?? session('error'))
        <x-adminlte-callout :icon="session('success') ? 'fas fa-check-circle' : 'fas fa-times'" :theme="session('success') ? 'success' : 'danger'" :title="$msg" :title-class="session('success') ? 'text-success' : 'text-danger'" />
    @endif
    {{-- @livewire('cca.operatividad.index') --}}
    aaa
@stop

{{-- Push extra CSS --}}

@push('css')
@endpush

{{-- Push extra scripts --}}

@push('js')
@endpush
