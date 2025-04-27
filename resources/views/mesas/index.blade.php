@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Mesas')
@section('content_header_title', 'Mesas')
@section('content_header_subtitle', 'Listar')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Mostrar un alert en caso de haber algun mensaje --}}
    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5><i class="fas fa-check-circle mr-2" style="color: #28a745"></i>{{ $message }}</h5>
        </div>
    @endif

    <div class="mb-4"><a href="{{ route('mesas.asignarpersonalmesa') }}" class="btn btn-success">Asignar Personal / Candidato a Mesa</a></div>
    

    <div class="row">
        
        @foreach ($mesas as $mesa)
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $mesa->mesa ?? 'N/A' }}</h3>

                        <p>{{ $mesa->estado ?? 'N/A' }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard"></i>
                    </div>
                    <a href="{{ route('mesas.show', $mesa->id_mesa) }}" class="small-box-footer">
                        Ver <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>


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
