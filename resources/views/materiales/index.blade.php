@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Materiales')
@section('content_header_title', 'Materiales')
@section('content_header_subtitle', 'Index')

@section('content_body')

    <h4 class="text-center">Bienvenidos al Módulo del Dpto. de Materiales del CBVP</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <a href="{{ route('materiales.mayor.index') }}" style="width:100%;color:black;font-weight:900;"
                            class="btn btn-warning">Material Mayor</a>
                    </div>
                    <div class="col-md-3 form-group">
                        <a href="{{ route('materiales.hidraulicos.index') }}" style="width:100%;color:black;font-weight:900;"
                            class="btn btn-warning">Equip. Hidraulicos</a>
                    </div>
                    <div class="col-md-3 form-group">
                        <a href="{{ route('materiales.conductores.index') }}" style="width:100%;color:black;font-weight:900;"
                            class="btn btn-warning">Conductores</a>
                    </div>
                    <div class="col-md-3 form-group">
                        <a href="#" style="width:100%;color:black;font-weight:900;" class="btn btn-warning">Material
                            Menor</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @livewire('materiales.index')

@stop

@push('css')
@endpush

@push('js')
@endpush
