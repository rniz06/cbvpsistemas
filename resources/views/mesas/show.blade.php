@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Mesas')
@section('content_header_title', 'Mesas')
@section('content_header_subtitle', 'Contador')

{{-- Content body: main page content --}}

@section('content_body')
<div class="mb-4"><a href="{{ route('mesas.asignarpersonalmesa') }}" class="btn btn-success">Asignar Personal / Candidato a Mesa</a></div>

@livewire('votacion-mesa', ['mesa' => $mesa])

    {{-- Mostrar un alert en caso de haber algun mensaje --}}


@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    {{-- <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script> --}}
@endpush
