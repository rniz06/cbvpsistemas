<div>

    {{-- =========================================================
         FILTROS
         ========================================================= --}}

    <x-card.card-filtro>

        <div class="row">

            <x-adminlte-input
                name="fecha_desde"
                type="date"
                wire:model.live="fecha_desde"
                label="Desde:"
                fgroup-class="col-md-2"
            />

            <x-adminlte-input
                name="fecha_hasta"
                type="date"
                wire:model.live="fecha_hasta"
                label="Hasta:"
                fgroup-class="col-md-2"
            />

            <div class="col-md-2">

                <x-adminlte-select
                    name="compania_id"
                    label="Compañía:"
                    wire:model.live.debounce.250ms="compania_id"
                >

                    <option value="">
                        Todas
                    </option>

                    @foreach ($companias as $compania)

                        <option value="{{ $compania->id_compania }}">
                            {{ $compania->compania }}
                        </option>

                    @endforeach

                </x-adminlte-select>

            </div>

            <div class="col-md-2">

                <x-adminlte-select
                    name="departamento_id"
                    label="Departamento:"
                    wire:model.live.debounce.250ms="departamento_id"
                >

                    <option value="">
                        Todos
                    </option>

                    @foreach ($departamentos as $departamento)

                        <option value="{{ $departamento->id_departamento }}">
                            {{ $departamento->departamento }}
                        </option>

                    @endforeach

                </x-adminlte-select>

            </div>

            <div class="col-md-2">

                <x-adminlte-select
                    name="ciudad_id"
                    label="Ciudad:"
                    wire:model.live.debounce.250ms="ciudad_id"
                >

                    <option value="">
                        Todas
                    </option>

                    @foreach (
                        $ciudades->when(
                            $departamento_id,
                            fn ($q) => $q->where(
                                'departamento_id',
                                $departamento_id
                            )
                        )
                        as $ciudad
                    )

                        <option value="{{ $ciudad->id_ciudad }}">
                            {{ $ciudad->ciudad }}
                        </option>

                    @endforeach

                </x-adminlte-select>

            </div>

            <div class="col-md-2">

                <x-adminlte-select
                    name="tipo_despacho"
                    label="Tipo:"
                    wire:model.live="tipo_despacho"
                >

                    <option value="todos">
                        Todos
                    </option>

                    <option value="principal">
                        Primera respuesta
                    </option>

                    <option value="apoyo">
                        Apoyo
                    </option>

                </x-adminlte-select>

            </div>

        </div>

<div class="row mt-2">

    <div class="col-md-3">

        <x-adminlte-select
            name="servicio_id"
            label="Servicio :"
            wire:model.live.debounce.250ms="servicio_id"
        >

            <option value="">
                Todos
            </option>

            @foreach ($servicios as $servicio)

                <option value="{{ $servicio->id_servicio }}">
                    {{ $servicio->nombre ?: $servicio->servicio }}
                </option>

            @endforeach

        </x-adminlte-select>

    </div>


    <div class="col-md-3">

        <x-adminlte-select
            name="clasificacion_id"
            label="Clasificación :"
            wire:model.live.debounce.250ms="clasificacion_id"
        >

            <option value="">
                Todas
            </option>

            @foreach ($clasificaciones as $clasificacion)

                <option
                    value="{{ $clasificacion->id_servicio_clasificacion }}"
                >
                    {{ $clasificacion->clasificacion }}
                </option>

            @endforeach

        </x-adminlte-select>

    </div>


    {{-- BOTÓN ALINEADO CON LOS SELECTS --}}

    <div class="col-md-3">

        <label class="d-block">
            &nbsp;
        </label>

        <x-adminlte-button
            class="btn-block"
            label="Limpiar filtros"
            theme="outline-secondary"
            icon="fas fa-eraser"
            wire:click="limpiarFiltros"
        />

    </div>

</div>


    </x-card.card-filtro>


    {{-- =========================================================
         TÍTULO
         ========================================================= --}}

    <div class="row mb-3">

        <div class="col-md-8">

            <h3 class="font-weight-bold">

                <i class="fas fa-fire text-danger mr-2"></i>

                Dashboard de Servicios 

            </h3>

            <span class="text-muted">

                Servicios donde el servicio y, cuando corresponde,
                la clasificación están marcados como .

            </span>

        </div>

    </div>


    {{-- =========================================================
         KPIs PRINCIPALES
         ========================================================= --}}

    <div class="row">

        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-danger">

                <div class="inner">

                    <h3>
                        {{ number_format(
                            $kpis['servicios'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </h3>

                    <p>
                        Servicios 
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-fire-extinguisher"></i>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-warning">

                <div class="inner">

                    <h3>
                        {{ number_format(
                            $kpis['apoyos'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </h3>

                    <p>
                        Despachos de Apoyo
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-ambulance"></i>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-info">

                <div class="inner">

                    <h3>
                        {{ number_format(
                            $kpis['total_despachos'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </h3>

                    <p>
                        Total de Despachos
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-truck-moving"></i>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-success">

                <div class="inner">

                    <h3>
                        {{ number_format(
                            $kpis['bomberos'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </h3>

                    <p>
                        Participaciones de Bomberos
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-user-shield"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         KPIs SECUNDARIOS
         =========================================================

    <div class="row">

        <div class="col-lg-3 col-md-6">

            <div class="info-box">

                <span class="info-box-icon bg-primary">

                    <i class="fas fa-users"></i>

                </span>

                <div class="info-box-content">

                    <span class="info-box-text">
                        Promedio tripulantes
                    </span>

                    <span class="info-box-number">

                        {{ number_format(
                            $kpis['promedio_bomberos'],
                            2,
                            ',',
                            '.'
                        ) }}

                    </span>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="info-box">

                <span class="info-box-icon bg-secondary">

                    <i class="fas fa-building"></i>

                </span>

                <div class="info-box-content">

                    <span class="info-box-text">
                        Compañías participantes
                    </span>

                    <span class="info-box-number">

                        {{ number_format(
                            $kpis['companias'],
                            0,
                            ',',
                            '.'
                        ) }}

                    </span>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="info-box">

                <span class="info-box-icon bg-dark">

                    <i class="fas fa-city"></i>

                </span>

                <div class="info-box-content">

                    <span class="info-box-text">
                        Ciudades
                    </span>

                    <span class="info-box-number">

                        {{ number_format(
                            $kpis['ciudades'],
                            0,
                            ',',
                            '.'
                        ) }}

                    </span>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="info-box">

                <span class="info-box-icon bg-purple">

                    <i class="fas fa-map-marked-alt"></i>

                </span>

                <div class="info-box-content">

                    <span class="info-box-text">
                        Departamentos
                    </span>

                    <span class="info-box-number">

                        {{ number_format(
                            $kpis['departamentos'],
                            0,
                            ',',
                            '.'
                        ) }}

                    </span>

                </div>

            </div>

        </div>

    </div>
 --}}

    {{-- =========================================================
         EVOLUCIÓN MENSUAL
         ========================================================= --}}

    <div class="card">

        <div class="card-header">

            <h3 class="card-title font-weight-bold">

                <i class="fas fa-chart-line mr-2"></i>

                Evolución mensual

            </h3>

        </div>

        <div class="card-body">

            <div
                style="height: 350px;"
                wire:ignore
            >

                <canvas id="MensualChart"></canvas>

            </div>

        </div>

    </div>


    {{-- =========================================================
         COMPAÑÍAS / DEPARTAMENTOS
         ========================================================= --}}

    <div class="row">

        <div class="col-md-6">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title font-weight-bold">

                        <i class="fas fa-building mr-2"></i>

                        Servicios por compañía

                    </h3>

                </div>

                <div class="card-body">

                    <div
                        style="height: 350px;"
                        wire:ignore
                    >

                        <canvas id="CompaniasChart"></canvas>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-6">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title font-weight-bold">

                        <i class="fas fa-map mr-2"></i>

                        Servicios por departamento

                    </h3>

                </div>

                <div class="card-body">

                    <div
                        style="height: 350px;"
                        wire:ignore
                    >

                        <canvas id="DepartamentosChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         SERVICIOS  / CLASIFICACIONES 
         
         IMPORTANTE:

         SIN SERVICIO SELECCIONADO:
             Servicios = col-md-12
             Clasificaciones = NO SE MUESTRA

         CON SERVICIO SELECCIONADO:
             Servicios = col-md-6
             Clasificaciones = col-md-6
         ========================================================= --}}

    <div class="row">

        {{-- =====================================================
             SERVICIOS 
             ===================================================== --}}

        <div class="{{ $servicio_id ? 'col-md-6' : 'col-md-12' }}">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title font-weight-bold">

                        <i class="fas fa-fire mr-2"></i>

                        Servicios 

                    </h3>

                </div>

                <div class="card-body">

                    <div
                        style="height: 400px;"
                        wire:ignore
                    >

                        <canvas id="ServiciosChart"></canvas>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             CLASIFICACIONES 

             SOLO APARECE CUANDO HAY SERVICIO SELECCIONADO
             ===================================================== --}}

        @if ($servicio_id)

            <div class="col-md-6">

                <div class="card">

                    <div class="card-header">

                        <h3 class="card-title font-weight-bold">

                            <i class="fas fa-tags mr-2"></i>

                            Clasificaciones 

                        </h3>

                    </div>

                    <div class="card-body">

                        <div
                            style="height: 400px;"
                            wire:ignore
                        >

                            <canvas
                                id="ClasificacionesChart"
                            ></canvas>

                        </div>

                    </div>

                </div>

            </div>

        @endif

    </div>


    {{-- =========================================================
         CIUDADES / TIPO DESPACHO
         ========================================================= --}}

    <div class="row">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title font-weight-bold">

                        <i class="fas fa-city mr-2"></i>

                        Top 20 ciudades

                    </h3>

                </div>

                <div class="card-body">

                    <div
                        style="height: 450px;"
                        wire:ignore
                    >

                        <canvas id="CiudadesChart"></canvas>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title font-weight-bold">

                        <i class="fas fa-truck-moving mr-2"></i>

                        Tipo de despacho

                    </h3>

                </div>

                <div class="card-body">

                    <div
                        style="height: 350px;"
                        wire:ignore
                    >

                        <canvas id="TipoChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         BOMBEROS
         ========================================================= --}}

    <div class="row">

        <div class="col-md-6">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title font-weight-bold">

                        <i class="fas fa-users mr-2"></i>

                        Bomberos participantes por compañía

                    </h3>

                </div>

                <div class="card-body">

                    <div
                        style="height: 400px;"
                        wire:ignore
                    >

                        <canvas
                            id="BomberosCompaniaChart"
                        ></canvas>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-6">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title font-weight-bold">

                        <i class="fas fa-user-friends mr-2"></i>

                        Bomberos participantes por servicio

                    </h3>

                </div>

                <div class="card-body">

                    <div
                        style="height: 400px;"
                        wire:ignore
                    >

                        <canvas
                            id="BomberosServicioChart"
                        ></canvas>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         JAVASCRIPT
         ========================================================= --}}

    @push('scripts')

        <script>

        (function () {

            'use strict';


            /*
            |--------------------------------------------------------------------------
            | INICIAR DASHBOARD
            |--------------------------------------------------------------------------
            */

            function iniciarCharts() {

                if (
                    typeof Chart === 'undefined' ||
                    window.__Charts
                ) {

                    return;

                }


                window.__Charts = {};


                const charts =
                    window.__Charts;


                /*
                |--------------------------------------------------------------------------
                | COLORES
                |--------------------------------------------------------------------------
                */

                const colores = {

                    rojo:
                        'rgba(220, 53, 69, 0.80)',

                    rojoBorde:
                        'rgba(220, 53, 69, 1)',

                    amarillo:
                        'rgba(255, 193, 7, 0.80)',

                    amarilloBorde:
                        'rgba(255, 193, 7, 1)',

                    azul:
                        'rgba(0, 123, 255, 0.80)',

                    azulBorde:
                        'rgba(0, 123, 255, 1)',

                    celeste:
                        'rgba(23, 162, 184, 0.80)',

                    celesteBorde:
                        'rgba(23, 162, 184, 1)',

                    verde:
                        'rgba(40, 167, 69, 0.80)',

                    verdeBorde:
                        'rgba(40, 167, 69, 1)',

                    morado:
                        'rgba(111, 66, 193, 0.80)',

                    moradoBorde:
                        'rgba(111, 66, 193, 1)'
                };


                const paleta = [

                    'rgba(220, 53, 69, 0.80)',
                    'rgba(0, 123, 255, 0.80)',
                    'rgba(40, 167, 69, 0.80)',
                    'rgba(255, 193, 7, 0.80)',
                    'rgba(111, 66, 193, 0.80)',
                    'rgba(23, 162, 184, 0.80)',
                    'rgba(253, 126, 20, 0.80)',
                    'rgba(108, 117, 125, 0.80)',
                    'rgba(32, 201, 151, 0.80)',
                    'rgba(232, 62, 140, 0.80)'
                ];


                const paletaBorde = [

                    'rgba(220, 53, 69, 1)',
                    'rgba(0, 123, 255, 1)',
                    'rgba(40, 167, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(111, 66, 193, 1)',
                    'rgba(23, 162, 184, 1)',
                    'rgba(253, 126, 20, 1)',
                    'rgba(108, 117, 125, 1)',
                    'rgba(32, 201, 151, 1)',
                    'rgba(232, 62, 140, 1)'
                ];


                /*
                |--------------------------------------------------------------------------
                | FUNCIONES AUXILIARES
                |--------------------------------------------------------------------------
                */

                function coloresPaleta(
                    cantidad,
                    paletaActual
                ) {

                    const resultado = [];

                    for (
                        let i = 0;
                        i < cantidad;
                        i++
                    ) {

                        resultado.push(
                            paletaActual[
                                i % paletaActual.length
                            ]
                        );

                    }

                    return resultado;
                }


                function numero(valor) {

                    return Number(
                        valor || 0
                    ).toLocaleString(
                        'es-PY'
                    );

                }


                function etiquetaCompania(
                    compania,
                    cantidad
                ) {

                    return (
                        compania +
                        ' [' +
                        numero(cantidad) +
                        ']'
                    );

                }


                function opcionesBase() {

                    return {

                        responsive:
                            true,

                        maintainAspectRatio:
                            false,

                        animation: {

                            duration:
                                0
                        },

                        responsiveAnimationDuration:
                            0,

                        events:
                            [],

                        tooltips: {

                            enabled:
                                false
                        },

                        hover: {

                            mode:
                                null,

                            animationDuration:
                                0
                        }

                    };

                }


                /*
                |--------------------------------------------------------------------------
                | CREAR CHART
                |--------------------------------------------------------------------------
                */

                function crearChart(
                    id,
                    config
                ) {

                    const canvas =
                        document.getElementById(id);


                    if (!canvas) {

                        return null;

                    }


                    if (charts[id]) {

                        return charts[id];

                    }


                    charts[id] =
                        new Chart(
                            canvas,
                            config
                        );


                    return charts[id];

                }


                /*
                |--------------------------------------------------------------------------
                | ACTUALIZAR CHART
                |--------------------------------------------------------------------------
                */

                function actualizarChart(
                    id,
                    labels,
                    datasets
                ) {

                    const chart =
                        charts[id];


                    if (!chart) {

                        return;

                    }


                    chart.data.labels =
                        Array.isArray(labels)
                            ? labels
                            : [];


                    chart.data.datasets =
                        Array.isArray(datasets)
                            ? datasets
                            : [];


                    chart.update(0);

                }


                /*
                |--------------------------------------------------------------------------
                | PLUGIN DE VALORES
                |--------------------------------------------------------------------------
                */

                const valoresVisiblesPlugin = {

                    afterDatasetsDraw:
                        function (chart) {


                            /*
                            |--------------------------------------------------------------------------
                            | NO MOSTRAR VALORES ENCIMA DE ESTAS DOS GRÁFICAS
                            |--------------------------------------------------------------------------
                            */

                            if (
                                chart.canvas &&
                                (
                                    chart.canvas.id ===
                                        'CompaniasChart' ||

                                    chart.canvas.id ===
                                        'BomberosCompaniaChart'
                                )
                            ) {

                                return;

                            }


                            const ctx =
                                chart.chart.ctx;


                            ctx.save();


                            ctx.font =
                                'bold 12px Arial';


                            ctx.fillStyle =
                                '#343a40';


                            ctx.textAlign =
                                'center';


                            ctx.textBaseline =
                                'middle';


                            /*
                            |--------------------------------------------------------------------------
                            | BARRAS
                            |--------------------------------------------------------------------------
                            */

                            if (
                                chart.config.type === 'bar' ||
                                chart.config.type === 'horizontalBar'
                            ) {

                                chart.data.datasets.forEach(
                                    function (
                                        dataset,
                                        datasetIndex
                                    ) {

                                        const meta =
                                            chart.getDatasetMeta(
                                                datasetIndex
                                            );


                                        meta.data.forEach(
                                            function (
                                                element,
                                                index
                                            ) {

                                                const valor =
                                                    dataset.data[index];


                                                if (
                                                    valor === null ||
                                                    valor === undefined
                                                ) {

                                                    return;

                                                }


                                                const pos =
                                                    element.tooltipPosition();


                                                if (
                                                    chart.config.type ===
                                                    'horizontalBar'
                                                ) {

                                                    ctx.textAlign =
                                                        'left';


                                                    ctx.textBaseline =
                                                        'middle';


                                                    ctx.fillText(
                                                        numero(valor),
                                                        pos.x + 8,
                                                        pos.y
                                                    );

                                                } else {

                                                    ctx.textAlign =
                                                        'center';


                                                    ctx.textBaseline =
                                                        'bottom';


                                                    ctx.fillText(
                                                        numero(valor),
                                                        pos.x,
                                                        pos.y - 7
                                                    );

                                                }

                                            }
                                        );

                                    }
                                );

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | LÍNEA
                            |--------------------------------------------------------------------------
                            */

                            if (
                                chart.config.type === 'line'
                            ) {

                                chart.data.datasets.forEach(
                                    function (
                                        dataset,
                                        datasetIndex
                                    ) {

                                        const meta =
                                            chart.getDatasetMeta(
                                                datasetIndex
                                            );


                                        meta.data.forEach(
                                            function (
                                                element,
                                                index
                                            ) {

                                                const valor =
                                                    dataset.data[index];


                                                if (
                                                    valor === null ||
                                                    valor === undefined
                                                ) {

                                                    return;

                                                }


                                                const pos =
                                                    element.tooltipPosition();


                                                ctx.textAlign =
                                                    'center';


                                                ctx.textBaseline =
                                                    'bottom';


                                                ctx.fillText(
                                                    numero(valor),
                                                    pos.x,
                                                    pos.y - 10
                                                );

                                            }
                                        );

                                    }
                                );

                            }


                            ctx.restore();

                        }

                };


                Chart.plugins.register(
                    valoresVisiblesPlugin
                );


                /*
                |--------------------------------------------------------------------------
                | 1. EVOLUCIÓN MENSUAL
                |--------------------------------------------------------------------------
                */

                crearChart(
                    'MensualChart',
                    {

                        type:
                            'line',

                        data: {

                            labels:
                                @json(
                                    $mensual->pluck('periodo')
                                ),

                            datasets: [

                                {

                                    label:
                                        'Servicios',

                                    data:
                                        @json(
                                            $mensual->pluck('cantidad')
                                        ),

                                    borderColor:
                                        colores.rojoBorde,

                                    backgroundColor:
                                        'rgba(220, 53, 69, 0.12)',

                                    borderWidth:
                                        3,

                                    fill:
                                        true,

                                    tension:
                                        0.3,

                                    pointRadius:
                                        4,

                                    pointBackgroundColor:
                                        colores.rojoBorde,

                                    pointBorderColor:
                                        '#ffffff',

                                    pointBorderWidth:
                                        2

                                },

                                {

                                    label:
                                        'Participaciones de bomberos',

                                    data:
                                        @json(
                                            $mensual->pluck('bomberos')
                                        ),

                                    borderColor:
                                        colores.azulBorde,

                                    backgroundColor:
                                        'rgba(0, 123, 255, 0.10)',

                                    borderWidth:
                                        3,

                                    fill:
                                        true,

                                    tension:
                                        0.3,

                                    pointRadius:
                                        4,

                                    pointBackgroundColor:
                                        colores.azulBorde,

                                    pointBorderColor:
                                        '#ffffff',

                                    pointBorderWidth:
                                        2

                                }

                            ]

                        },

                        options:
                            Object.assign(
                                opcionesBase(),
                                {

                                    legend: {

                                        display:
                                            true

                                    },

                                    scales: {

                                        yAxes: [

                                            {

                                                ticks: {

                                                    beginAtZero:
                                                        true,

                                                    precision:
                                                        0

                                                }

                                            }

                                        ]

                                    }

                                }
                            )

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | 2. SERVICIOS POR COMPAÑÍA
                |--------------------------------------------------------------------------
                */

                const companiasInicial =
                    @json(
                        $companiasGrafico
                    );


                crearChart(
                    'CompaniasChart',
                    {

                        type:
                            'horizontalBar',

                        data: {

                            labels:
                                companiasInicial.map(
                                    function (item) {

                                        return etiquetaCompania(
                                            item.compania,
                                            item.cantidad
                                        );

                                    }
                                ),

                            datasets: [

                                {

                                    label:
                                        'Servicios',

                                    data:
                                        companiasInicial.map(
                                            function (item) {

                                                return Number(
                                                    item.cantidad || 0
                                                );

                                            }
                                        ),

                                    backgroundColor:
                                        coloresPaleta(
                                            companiasInicial.length,
                                            paleta
                                        ),

                                    borderColor:
                                        coloresPaleta(
                                            companiasInicial.length,
                                            paletaBorde
                                        ),

                                    borderWidth:
                                        1

                                }

                            ]

                        },

                        options:
                            Object.assign(
                                opcionesBase(),
                                {

                                    legend: {

                                        display:
                                            false

                                    },

                                    scales: {

                                        xAxes: [

                                            {

                                                ticks: {

                                                    autoSkip:
                                                        false,

                                                    maxRotation:
                                                        45,

                                                    minRotation:
                                                        45

                                                }

                                            }

                                        ],

                                        yAxes: [

                                            {

                                                ticks: {

                                                    beginAtZero:
                                                        true,

                                                    precision:
                                                        0

                                                }

                                            }

                                        ]

                                    }

                                }
                            )

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | 3. SERVICIOS POR DEPARTAMENTO
                |--------------------------------------------------------------------------
                */

                crearChart(
                    'DepartamentosChart',
                    {

                        type:
                            'bar',

                        data: {

                            labels:
                                @json(
                                    $departamentosGrafico
                                        ->pluck('departamento')
                                ),

                            datasets: [

                                {

                                    label:
                                        'Servicios',

                                    data:
                                        @json(
                                            $departamentosGrafico
                                                ->pluck('cantidad')
                                        ),

                                    backgroundColor:
                                        colores.morado,

                                    borderColor:
                                        colores.moradoBorde,

                                    borderWidth:
                                        1

                                }

                            ]

                        },

                        options:
                            Object.assign(
                                opcionesBase(),
                                {

                                    legend: {

                                        display:
                                            false

                                    },

                                    scales: {

                                        xAxes: [

                                            {

                                                ticks: {

                                                    autoSkip:
                                                        false,

                                                    maxRotation:
                                                        45,

                                                    minRotation:
                                                        45

                                                }

                                            }

                                        ],

                                        yAxes: [

                                            {

                                                ticks: {

                                                    beginAtZero:
                                                        true,

                                                    precision:
                                                        0

                                                }

                                            }

                                        ]

                                    }

                                }
                            )

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | 4. SERVICIOS 
                |--------------------------------------------------------------------------
                */

                crearChart(
                    'ServiciosChart',
                    {

                        type:
                            'horizontalBar',

                        data: {

                            labels:
                                @json(
                                    $serviciosGrafico
                                        ->pluck('nombre')
                                ),

                            datasets: [

                                {

                                    label:
                                        'Cantidad',

                                    data:
                                        @json(
                                            $serviciosGrafico
                                                ->pluck('cantidad')
                                        ),

                                    backgroundColor:
                                        coloresPaleta(
                                            @json(
                                                $serviciosGrafico->count()
                                            ),
                                            paleta
                                        ),

                                    borderColor:
                                        coloresPaleta(
                                            @json(
                                                $serviciosGrafico->count()
                                            ),
                                            paletaBorde
                                        ),

                                    borderWidth:
                                        1

                                }

                            ]

                        },

                        options:
                            Object.assign(
                                opcionesBase(),
                                {

                                    legend: {

                                        display:
                                            false

                                    },

                                    scales: {

                                        xAxes: [

                                            {

                                                ticks: {

                                                    beginAtZero:
                                                        true,

                                                    precision:
                                                        0

                                                }

                                            }

                                        ]

                                    }

                                }
                            )

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | FUNCIÓN PARA CREAR CLASIFICACIONES
                |--------------------------------------------------------------------------
                |
                | IMPORTANTE:
                |
                | Este gráfico puede aparecer/desaparecer
                | dinámicamente cuando cambia servicio_id.
                |
                |--------------------------------------------------------------------------
                */

                function crearClasificacionesChart(
                    clasificaciones
                ) {

                    const canvas =
                        document.getElementById(
                            'ClasificacionesChart'
                        );


                    if (!canvas) {

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SI YA EXISTE, NO LO CREAMOS DE NUEVO
                    |--------------------------------------------------------------------------
                    */

                    if (
                        charts.ClasificacionesChart
                    ) {

                        actualizarChart(
                            'ClasificacionesChart',

                            clasificaciones.map(
                                function (item) {

                                    return item.clasificacion;

                                }
                            ),

                            [

                                {

                                    data:
                                        clasificaciones.map(
                                            function (item) {

                                                return Number(
                                                    item.cantidad || 0
                                                );

                                            }
                                        ),

                                    backgroundColor:
                                        coloresPaleta(
                                            clasificaciones.length,
                                            paleta
                                        ),

                                    borderColor:
                                        '#ffffff',

                                    borderWidth:
                                        2

                                }

                            ]
                        );

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CREAR CHART
                    |--------------------------------------------------------------------------
                    */

                    crearChart(
                        'ClasificacionesChart',
                        {

                            type:
                                'doughnut',

                            data: {

                                labels:
                                    clasificaciones.map(
                                        function (item) {

                                            return item.clasificacion;

                                        }
                                    ),

                                datasets: [

                                    {

                                        data:
                                            clasificaciones.map(
                                                function (item) {

                                                    return Number(
                                                        item.cantidad || 0
                                                    );

                                                }
                                            ),

                                        backgroundColor:
                                            coloresPaleta(
                                                clasificaciones.length,
                                                paleta
                                            ),

                                        borderColor:
                                            '#ffffff',

                                        borderWidth:
                                            2

                                    }

                                ]

                            },

                            options:
                                Object.assign(
                                    opcionesBase(),
                                    {

                                        legend: {

                                            position:
                                                'right',

                                            labels: {

                                                generateLabels:
                                                    function (chart) {

                                                        const data =
                                                            chart.data;


                                                        if (
                                                            !data.labels ||
                                                            !data.labels.length
                                                        ) {

                                                            return [];

                                                        }


                                                        return data.labels.map(
                                                            function (
                                                                label,
                                                                index
                                                            ) {

                                                                const valor =
                                                                    data
                                                                        .datasets[0]
                                                                        .data[index];


                                                                return {

                                                                    text:
                                                                        label +
                                                                        ' — ' +
                                                                        numero(
                                                                            valor
                                                                        ),

                                                                    fillStyle:
                                                                        data
                                                                            .datasets[0]
                                                                            .backgroundColor[
                                                                                index
                                                                            ],

                                                                    strokeStyle:
                                                                        '#ffffff',

                                                                    lineWidth:
                                                                        2,

                                                                    hidden:
                                                                        false,

                                                                    index:
                                                                        index

                                                                };

                                                            }
                                                        );

                                                    }

                                            }

                                        }

                                    }
                                )

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | 5. CLASIFICACIONES INICIAL
                |--------------------------------------------------------------------------
                |
                | Si al cargar la página ya hay un servicio seleccionado,
                | creamos el gráfico.
                |
                |--------------------------------------------------------------------------
                */

                const clasificacionesInicial =
                    @json(
                        $clasificacionesGrafico
                    );


                if (
                    document.getElementById(
                        'ClasificacionesChart'
                    )
                ) {

                    crearClasificacionesChart(
                        clasificacionesInicial
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | 6. TOP 20 CIUDADES
                |--------------------------------------------------------------------------
                */

                crearChart(
                    'CiudadesChart',
                    {

                        type:
                            'horizontalBar',

                        data: {

                            labels:
                                @json(
                                    $ciudadesGrafico->map(
                                        function ($item) {

                                            return
                                                $item->ciudad .
                                                ' - ' .
                                                $item->departamento;

                                        }
                                    )
                                ),

                            datasets: [

                                {

                                    label:
                                        'Servicios',

                                    data:
                                        @json(
                                            $ciudadesGrafico
                                                ->pluck('cantidad')
                                        ),

                                    backgroundColor:
                                        colores.celeste,

                                    borderColor:
                                        colores.celesteBorde,

                                    borderWidth:
                                        1

                                }

                            ]

                        },

                        options:
                            Object.assign(
                                opcionesBase(),
                                {

                                    legend: {

                                        display:
                                            false

                                    },

                                    scales: {

                                        xAxes: [

                                            {

                                                ticks: {

                                                    beginAtZero:
                                                        true,

                                                    precision:
                                                        0

                                                }

                                            }

                                        ]

                                    }

                                }
                            )

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | 7. TIPO DE DESPACHO
                |--------------------------------------------------------------------------
                */

                crearChart(
                    'TipoChart',
                    {

                        type:
                            'doughnut',

                        data: {

                            labels: [

                                'Primera respuesta',

                                'Apoyo'

                            ],

                            datasets: [

                                {

                                    data: [

                                        @json(
                                            $tipoDespachoGrafico[
                                                'principal'
                                            ]
                                        ),

                                        @json(
                                            $tipoDespachoGrafico[
                                                'apoyo'
                                            ]
                                        )

                                    ],

                                    backgroundColor: [

                                        colores.rojo,

                                        colores.amarillo

                                    ],

                                    borderColor: [

                                        colores.rojoBorde,

                                        colores.amarilloBorde

                                    ],

                                    borderWidth:
                                        2

                                }

                            ]

                        },

                        options:
                            Object.assign(
                                opcionesBase(),
                                {

                                    legend: {

                                        position:
                                            'bottom',

                                        labels: {

                                            generateLabels:
                                                function (chart) {

                                                    const data =
                                                        chart.data;


                                                    return data.labels.map(
                                                        function (
                                                            label,
                                                            index
                                                        ) {

                                                            return {

                                                                text:
                                                                    label +
                                                                    ' — ' +
                                                                    numero(
                                                                        data
                                                                            .datasets[0]
                                                                            .data[index]
                                                                    ),

                                                                fillStyle:
                                                                    data
                                                                        .datasets[0]
                                                                        .backgroundColor[
                                                                            index
                                                                        ],

                                                                strokeStyle:
                                                                    data
                                                                        .datasets[0]
                                                                        .borderColor[
                                                                            index
                                                                        ],

                                                                lineWidth:
                                                                    2,

                                                                hidden:
                                                                    false,

                                                                index:
                                                                    index

                                                            };

                                                        }
                                                    );

                                                }

                                        }

                                    }

                                }
                            )

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | 8. BOMBEROS POR COMPAÑÍA
                |--------------------------------------------------------------------------
                */

                const bomberosCompaniaInicial =
                    @json(
                        $bomberosCompaniaGrafico
                    );


                crearChart(
                    'BomberosCompaniaChart',
                    {

                        type:
                            'horizontalBar',

                        data: {

                            labels:
                                bomberosCompaniaInicial.map(
                                    function (item) {

                                        return etiquetaCompania(
                                            item.compania,
                                            item.bomberos
                                        );

                                    }
                                ),

                            datasets: [

                                {

                                    label:
                                        'Participaciones',

                                    data:
                                        bomberosCompaniaInicial.map(
                                            function (item) {

                                                return Number(
                                                    item.bomberos || 0
                                                );

                                            }
                                        ),

                                    backgroundColor:
                                        colores.verde,

                                    borderColor:
                                        colores.verdeBorde,

                                    borderWidth:
                                        1

                                }

                            ]

                        },

                        options:
                            Object.assign(
                                opcionesBase(),
                                {

                                    legend: {

                                        display:
                                            false

                                    },

                                    scales: {

                                        xAxes: [

                                            {

                                                ticks: {

                                                    autoSkip:
                                                        false,

                                                    maxRotation:
                                                        45,

                                                    minRotation:
                                                        45

                                                }

                                            }

                                        ],

                                        yAxes: [

                                            {

                                                ticks: {

                                                    beginAtZero:
                                                        true,

                                                    precision:
                                                        0

                                                }

                                            }

                                        ]

                                    }

                                }
                            )

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | 9. BOMBEROS POR SERVICIO
                |--------------------------------------------------------------------------
                */

                crearChart(
                    'BomberosServicioChart',
                    {

                        type:
                            'horizontalBar',

                        data: {

                            labels:
                                @json(
                                    $bomberosServicioGrafico
                                        ->pluck('nombre')
                                ),

                            datasets: [

                                {

                                    label:
                                        'Participaciones',

                                    data:
                                        @json(
                                            $bomberosServicioGrafico
                                                ->pluck('bomberos')
                                        ),

                                    backgroundColor:
                                        colores.azul,

                                    borderColor:
                                        colores.azulBorde,

                                    borderWidth:
                                        1

                                }

                            ]

                        },

                        options:
                            Object.assign(
                                opcionesBase(),
                                {

                                    legend: {

                                        display:
                                            false

                                    },

                                    scales: {

                                        xAxes: [

                                            {

                                                ticks: {

                                                    beginAtZero:
                                                        true,

                                                    precision:
                                                        0

                                                }

                                            }

                                        ]

                                    }

                                }
                            )

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | LIVEWIRE
                |--------------------------------------------------------------------------
                */

                Livewire.on(
                    'misionales-charts-updated',
                    function (event) {

                        setTimeout(function () {


                        /*
                        |--------------------------------------------------------------------------
                        | 1. MENSUAL
                        |--------------------------------------------------------------------------
                        */

                        const mensual =
                            Array.isArray(
                                event.mensual
                            )
                                ? event.mensual
                                : [];


                        actualizarChart(
                            'MensualChart',

                            mensual.map(
                                function (item) {

                                    return item.periodo;

                                }
                            ),

                            [

                                {

                                    label:
                                        'Servicios',

                                    data:
                                        mensual.map(
                                            function (item) {

                                                return Number(
                                                    item.cantidad || 0
                                                );

                                            }
                                        ),

                                    borderColor:
                                        colores.rojoBorde,

                                    backgroundColor:
                                        'rgba(220, 53, 69, 0.12)',

                                    borderWidth:
                                        3,

                                    fill:
                                        true,

                                    tension:
                                        0.3,

                                    pointRadius:
                                        4,

                                    pointBackgroundColor:
                                        colores.rojoBorde,

                                    pointBorderColor:
                                        '#ffffff',

                                    pointBorderWidth:
                                        2

                                },

                                {

                                    label:
                                        'Participaciones de bomberos',

                                    data:
                                        mensual.map(
                                            function (item) {

                                                return Number(
                                                    item.bomberos || 0
                                                );

                                            }
                                        ),

                                    borderColor:
                                        colores.azulBorde,

                                    backgroundColor:
                                        'rgba(0, 123, 255, 0.10)',

                                    borderWidth:
                                        3,

                                    fill:
                                        true,

                                    tension:
                                        0.3,

                                    pointRadius:
                                        4,

                                    pointBackgroundColor:
                                        colores.azulBorde,

                                    pointBorderColor:
                                        '#ffffff',

                                    pointBorderWidth:
                                        2

                                }

                            ]
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | 2. COMPAÑÍAS
                        |--------------------------------------------------------------------------
                        */

                        const companias =
                            Array.isArray(
                                event.companias
                            )
                                ? event.companias
                                : [];


                        actualizarChart(
                            'CompaniasChart',

                            companias.map(
                                function (item) {

                                    return etiquetaCompania(
                                        item.compania,
                                        item.cantidad
                                    );

                                }
                            ),

                            [

                                {

                                    label:
                                        'Servicios',

                                    data:
                                        companias.map(
                                            function (item) {

                                                return Number(
                                                    item.cantidad || 0
                                                );

                                            }
                                        ),

                                    backgroundColor:
                                        coloresPaleta(
                                            companias.length,
                                            paleta
                                        ),

                                    borderColor:
                                        coloresPaleta(
                                            companias.length,
                                            paletaBorde
                                        ),

                                    borderWidth:
                                        1

                                }

                            ]
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | 3. DEPARTAMENTOS
                        |--------------------------------------------------------------------------
                        */

                        const departamentos =
                            Array.isArray(
                                event.departamentos
                            )
                                ? event.departamentos
                                : [];


                        actualizarChart(
                            'DepartamentosChart',

                            departamentos.map(
                                function (item) {

                                    return item.departamento;

                                }
                            ),

                            [

                                {

                                    label:
                                        'Servicios',

                                    data:
                                        departamentos.map(
                                            function (item) {

                                                return Number(
                                                    item.cantidad || 0
                                                );

                                            }
                                        ),

                                    backgroundColor:
                                        colores.morado,

                                    borderColor:
                                        colores.moradoBorde,

                                    borderWidth:
                                        1

                                }

                            ]
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | 4. SERVICIOS
                        |--------------------------------------------------------------------------
                        */

                        const servicios =
                            Array.isArray(
                                event.servicios
                            )
                                ? event.servicios
                                : [];


                        actualizarChart(
                            'ServiciosChart',

                            servicios.map(
                                function (item) {

                                    return item.nombre;

                                }
                            ),

                            [

                                {

                                    label:
                                        'Cantidad',

                                    data:
                                        servicios.map(
                                            function (item) {

                                                return Number(
                                                    item.cantidad || 0
                                                );

                                            }
                                        ),

                                    backgroundColor:
                                        coloresPaleta(
                                            servicios.length,
                                            paleta
                                        ),

                                    borderColor:
                                        coloresPaleta(
                                            servicios.length,
                                            paletaBorde
                                        ),

                                    borderWidth:
                                        1

                                }

                            ]
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | 5. CLASIFICACIONES
                        |--------------------------------------------------------------------------
                        |
                        | PRIMERO:
                        | si el canvas desapareció porque volvimos a "Todos",
                        | destruimos el chart anterior.
                        |
                        |--------------------------------------------------------------------------
                        */

                        const canvasClasificaciones =
                            document.getElementById(
                                'ClasificacionesChart'
                            );


                        if (!canvasClasificaciones) {


                            if (
                                charts
                                    .ClasificacionesChart
                            ) {

                                try {

                                    charts
                                        .ClasificacionesChart
                                        .destroy();

                                } catch (e) {

                                    // No hacer nada

                                }


                                delete charts
                                    .ClasificacionesChart;

                            }


                        } else {


                            const clasificaciones =
                                Array.isArray(
                                    event.clasificaciones
                                )
                                    ? event.clasificaciones
                                    : [];


                            crearClasificacionesChart(
                                clasificaciones
                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | 6. CIUDADES
                        |--------------------------------------------------------------------------
                        */

                        const ciudades =
                            Array.isArray(
                                event.ciudades
                            )
                                ? event.ciudades
                                : [];


                        actualizarChart(
                            'CiudadesChart',

                            ciudades.map(
                                function (item) {

                                    return (
                                        item.ciudad +
                                        ' - ' +
                                        item.departamento
                                    );

                                }
                            ),

                            [

                                {

                                    label:
                                        'Servicios',

                                    data:
                                        ciudades.map(
                                            function (item) {

                                                return Number(
                                                    item.cantidad || 0
                                                );

                                            }
                                        ),

                                    backgroundColor:
                                        colores.celeste,

                                    borderColor:
                                        colores.celesteBorde,

                                    borderWidth:
                                        1

                                }

                            ]
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | 7. TIPO DE DESPACHO
                        |--------------------------------------------------------------------------
                        */

                        const tipo =
                            event.tipo ||
                            {};


                        actualizarChart(
                            'TipoChart',

                            [

                                'Primera respuesta',

                                'Apoyo'

                            ],

                            [

                                {

                                    data: [

                                        Number(
                                            tipo.principal ||
                                            0
                                        ),

                                        Number(
                                            tipo.apoyo ||
                                            0
                                        )

                                    ],

                                    backgroundColor: [

                                        colores.rojo,

                                        colores.amarillo

                                    ],

                                    borderColor: [

                                        colores.rojoBorde,

                                        colores.amarilloBorde

                                    ],

                                    borderWidth:
                                        2

                                }

                            ]
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | 8. BOMBEROS POR COMPAÑÍA
                        |--------------------------------------------------------------------------
                        */

                        const bomberosCompania =
                            Array.isArray(
                                event.bomberosCompania
                            )
                                ? event.bomberosCompania
                                : [];


                        actualizarChart(
                            'BomberosCompaniaChart',

                            bomberosCompania.map(
                                function (item) {

                                    return etiquetaCompania(
                                        item.compania,
                                        item.bomberos
                                    );

                                }
                            ),

                            [

                                {

                                    label:
                                        'Participaciones',

                                    data:
                                        bomberosCompania.map(
                                            function (item) {

                                                return Number(
                                                    item.bomberos || 0
                                                );

                                            }
                                        ),

                                    backgroundColor:
                                        colores.verde,

                                    borderColor:
                                        colores.verdeBorde,

                                    borderWidth:
                                        1

                                }

                            ]
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | 9. BOMBEROS POR SERVICIO
                        |--------------------------------------------------------------------------
                        */

                        const bomberosServicio =
                            Array.isArray(
                                event.bomberosServicio
                            )
                                ? event.bomberosServicio
                                : [];


                        actualizarChart(
                            'BomberosServicioChart',

                            bomberosServicio.map(
                                function (item) {

                                    return item.nombre;

                                }
                            ),

                            [

                                {

                                    label:
                                        'Participaciones',

                                    data:
                                        bomberosServicio.map(
                                            function (item) {

                                                return Number(
                                                    item.bomberos || 0
                                                );

                                            }
                                        ),

                                    backgroundColor:
                                        colores.azul,

                                    borderColor:
                                        colores.azulBorde,

                                    borderWidth:
                                        1

                                }

                            ]
                        );

                        }, 50);

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | INICIALIZACIÓN
            |--------------------------------------------------------------------------
            */

            document.addEventListener(
                'livewire:init',
                function () {

                    iniciarCharts();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | SI LIVEWIRE YA ESTÁ CARGADO
            |--------------------------------------------------------------------------
            */

            if (window.Livewire) {

                setTimeout(
                    function () {

                        iniciarCharts();

                    },
                    100
                );

            }

        })();

        </script>

    @endpush

</div>