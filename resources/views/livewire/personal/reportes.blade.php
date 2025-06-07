<div>

    {{-- Filtros de Búsqueda --}}
    <x-card.card-filtro>
        <div class="row">
            <div class="col-sm-3">
                <!-- select -->
                <div class="form-group">
                    <label>Compañia:</label>
                    <select class="form-control" wire:model.live="compania_id">
                        <option value="">Todos</option>
                        @foreach ($companias as $compania)
                            <option value="{{ $compania->idcompanias }}">{{ $compania->compania ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-3">
                <!-- select -->
                <div class="form-group">
                    <label>Categoria:</label>
                    <select class="form-control" wire:model.live="categoria_id">
                        <option value="">Todos</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->idpersonal_categorias }}">{{ $categoria->categoria ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-3">
                <!-- select -->
                <div class="form-group">
                    <label>Estado:</label>
                    <select class="form-control" wire:model.live="estado_id">
                        <option value="">Todos</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->idpersonal_estados }}">{{ $estado->estado ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-3">
                <!-- select -->
                <div class="form-group">
                    <label>Estado Actualizar:</label>
                    <select class="form-control" wire:model.live="estado_actualizar_id">
                        <option value="">Todos</option>
                        @foreach ($estados_actualizar as $estado_actualizar)
                            <option value="{{ $estado_actualizar->idpersonal_estado_actualizar }}">{{ $estado_actualizar->estado ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
    </x-card.card-filtro>

    <div class="row">
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

    {{-- <div class="row">
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
</div>

@push('scripts')
    {{-- <script>
        // Obtener los datos desde PHP
        const totalPersonal = {{ $total_personal }};
        const totalCombatientes = {{ $total_combatientes }};
        const totalActivos = {{ $total_activos }};
        const totalFaltaActualizar = {{ $total_falta_actualizar }};

        // Inicializar el gráfico
        const ctx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total', 'Combatientes', 'Activos', 'Falta Actualizar'],
                datasets: [{
                    label: 'Cantidad Total en General de Personal',
                    data: [totalPersonal, totalCombatientes, totalActivos, totalFaltaActualizar],
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.6)', // Total
                        'rgba(75, 192, 192, 0.6)', // Combatientes
                        'rgba(153, 102, 255, 0.6)' // Activos
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // IMPORTANTE: permite que la altura CSS se aplique
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script> --}}
@endpush
