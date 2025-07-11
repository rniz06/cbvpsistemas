@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Personal')
@section('content_header_title', 'Personal')
@section('content_header_subtitle', 'Reportes')

{{-- Content body: main page content --}}

@section('content_body')

    @livewire('personal.reportes')
    {{-- <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($total_personal, 0, '.', '.') }}</h3>

                    <p>Total de Voluntarios Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                @can('Personal Listar')
                    <a href="{{ route('personal.index') }}" class="small-box-footer">Ver Más... <i
                            class="fas fa-arrow-circle-right"></i></a>
                @endcan
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($total_combatientes, 0, '.', '.') }}</h3>

                    <p>En la categoria Combatiente</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hiking"></i>
                </div>
                @can('Personal Listar')
                    <a href="{{ route('personal.index') }}" class="small-box-footer">Ver Más... <i
                            class="fas fa-arrow-circle-right"></i></a>
                @endcan
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($total_activos, 0, '.', '.') }}</h3>

                    <p>En la categoria Activo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fire-alt"></i>
                </div>
                @can('Personal Listar')
                    <a href="{{ route('personal.index') }}" class="small-box-footer">Ver Más... <i
                            class="fas fa-arrow-circle-right"></i></a>
                @endcan
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($total_falta_actualizar, 0, '.', '.') }}</h3>

                    <p>Falta Actualizar Datos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-edit"></i>
                </div>
                @can('Personal Listar')
                    <a href="{{ route('personal.index') }}" class="small-box-footer">Ver Más... <i
                            class="fas fa-arrow-circle-right"></i></a>
                @endcan
            </div>
        </div>
        <!-- ./col -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Grafico de Cantidad de Personal</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="barChart" class="w-100" style="height: 300px;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div> --}}
@stop

@section('plugins.Chartjs', true)

{{-- Push extra CSS --}}

@push('css')
@endpush

{{-- Push extra scripts --}}

@push('js')
    {{-- Incluir scripts js adicionales desde el componente --}}
    @stack('scripts')
@endpush
