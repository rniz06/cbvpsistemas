@extends('layouts.app')

@section('subtitle', 'CCA')
@section('content_header_title', 'CCA')
@section('content_header_subtitle', 'Dashboard de Servicios Misionales')

@section('content_body')

    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5>
                <i class="fas fa-check-circle mr-2"></i>
                {{ $message }}
            </h5>
        </div>
    @endif

    @livewire('cca.reportes.misionales')

@stop

@push('css')
    @stack('styles')
@endpush

@push('js')
    @stack('scripts')
@endpush