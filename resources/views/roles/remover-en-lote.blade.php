@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Roles')
@section('content_header_title', 'Roles')
@section('content_header_subtitle', 'Remover en lote')

{{-- Content body: main page content --}}

@section('content_body')
    {{-- MOSTRAR UN ALERT EN CASO DE HABER ALGUN MENSAJE : SUCCESS O ERROR --}}
    @if ($msg = session('success') ?? session('error'))
        <x-adminlte-callout :icon="session('success') ? 'fas fa-check-circle' : 'fas fa-times'" :theme="session('success') ? 'success' : 'danger'" :title="$msg" :title-class="session('success') ? 'text-success' : 'text-danger'" />
    @endif
    {{-- INCLUIR COMPONENTE LIVEWIRE --}}
    @livewire('admin.roles.remover-en-lote')
@stop

{{-- Push extra CSS --}}

@push('css')
@endpush

{{-- Push extra scripts --}}

@push('js')
@endpush
