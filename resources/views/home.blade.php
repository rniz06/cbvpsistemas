@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Inicio')
@section('content_header_title', 'Inicio')
@section('content_header_subtitle', 'Bienvenida')

{{-- Content body: main page content --}}

@section('content_body')
    <p>Bienvenidos al panel de administración.</p>
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