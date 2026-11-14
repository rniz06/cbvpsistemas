<div wire:poll.30s class="panel-inicio">

    @push('css')
        <style>
            /* =====================================================
               PANEL GENERAL
            ===================================================== */

            .panel-inicio {
                color: #343a40;
            }

            .inicio-card {
                height: 100%;
                padding: 15px;
                background: #fff;
                border: 1px solid #e8ebef;
                border-radius: 12px;
                box-shadow: 0 3px 12px rgba(0, 0, 0, .045);
            }

            .inicio-card-header {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 14px;
            }

            .inicio-icono {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                width: 36px;
                height: 36px;
                border-radius: 10px;
                background: #eef3f8;
                color: #315b7d;
                font-size: 17px;
            }

            .inicio-titulo {
                margin: 0;
                font-size: 15px;
                font-weight: 700;
            }

            .inicio-subtitulo {
                margin-top: 3px;
                color: #7a8490;
                font-size: 11px;
            }

            /* =====================================================
               INDICADORES
            ===================================================== */

            .inicio-indicadores {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
            }

            .inicio-indicador {
                padding: 10px 5px;
                border-radius: 9px;
                background: #f7f9fb;
                text-align: center;
            }

            .inicio-indicador strong {
                display: block;
                color: #263746;
                font-size: 22px;
                line-height: 1.2;
            }

            .inicio-indicador span {
                display: block;
                margin-top: 4px;
                color: #6c757d;
                font-size: 10px;
            }

            /* =====================================================
               ESTADOS
            ===================================================== */

            .inicio-estado {
                display: inline-block;
                padding: 4px 8px;
                border-radius: 20px;
                font-size: 10px;
                font-weight: 700;
                white-space: nowrap;
            }

            .inicio-verde {
                background: #28a745;
                color: #fff;
            }

            .inicio-celeste {
                background: #17a2b8;
                color: #fff;
            }

            .inicio-amarillo {
                background: #ffc107;
                color: #212529;
            }

            .inicio-rojo {
                background: #dc3545;
                color: #fff;
            }

            /* =====================================================
               LISTAS DE MÓVILES
            ===================================================== */

            .inicio-lista {
                display: flex;
                flex-direction: column;
                gap: 6px;
                max-height: 250px;
                overflow-y: auto;
            }

            .inicio-lista-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 8px;
                padding: 8px 9px;
                border: 1px solid #edf0f2;
                border-radius: 8px;
                background: #f8f9fa;
                font-size: 12px;
            }

            .inicio-lista-item strong {
                font-weight: 700;
                overflow-wrap: anywhere;
            }

            .inicio-vacio {
                padding: 13px 6px;
                color: #89939d;
                text-align: center;
                font-size: 12px;
            }

            /* =====================================================
               SITUACIÓN NACIONAL
            ===================================================== */

            .inicio-nacional-contenido {
                max-height: 430px;
                overflow-y: auto;
                padding-right: 3px;
            }

            .inicio-departamento {
                margin-bottom: 12px;
            }

            .inicio-departamento-titulo {
                margin-bottom: 6px;
                padding: 5px 8px;
                background: #e9ecef;
                border-left: 4px solid #343a40;
                border-radius: 3px;
                color: #212529;
                font-size: 12px;
                font-weight: 800;
                line-height: 1.2;
                text-transform: uppercase;
            }

            .inicio-companias-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 5px;
            }

            .inicio-compania {
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 0;
                min-height: 34px;
                padding: 5px 4px;
                border: 1px solid rgba(0, 0, 0, .06);
                border-radius: 4px;
                text-align: center;
                font-size: 10px;
                font-weight: 700;
                line-height: 1.1;
                overflow-wrap: anywhere;
                word-break: normal;
            }

            .inicio-leyenda {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-bottom: 12px;
                color: #6c757d;
                font-size: 10px;
            }

            .inicio-leyenda span {
                display: inline-flex;
                align-items: center;
                gap: 4px;
            }

            .inicio-punto {
                display: inline-block;
                width: 8px;
                height: 8px;
                border-radius: 2px;
            }

            /* =====================================================
               RESPONSIVE
            ===================================================== */

            @media (max-width: 1199px) {
                .inicio-companias-grid {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
            }

            @media (max-width: 800px) {
                .inicio-card {
                    padding: 12px;
                }

                .inicio-indicador strong {
                    font-size: 19px;
                }

                .inicio-companias-grid {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
            }

            @media (max-width: 500px) {
                .inicio-companias-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .inicio-compania {
                    min-height: 36px;
                    font-size: 10px;
                }
            }
        </style>
    @endpush

    <div class="row">

        {{-- =====================================================
             MI COMPAÑÍA
        ====================================================== --}}

        <div class="col-xl-4 col-md-6 mb-3">
            <div class="inicio-card">

                <div class="inicio-card-header">
                    <div class="inicio-icono">
                        <i class="fas fa-building"></i>
                    </div>

                    <div>
                        <h3 class="inicio-titulo">Mi compañía</h3>
                        <div class="inicio-subtitulo">
                            Última condición de guardia · CCA
                        </div>
                    </div>
                </div>

                @if ($compania)

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <strong>{{ $compania->compania }}</strong>

                        @if (!$ultimaFicha)
                            <span class="inicio-estado inicio-amarillo">
                                Sin registro
                            </span>
                        @elseif (!$ultimaFicha->operativo)
                            <span class="inicio-estado inicio-rojo">
                                Inoperativa
                            </span>
                        @elseif (($ultimaFicha->cant_personal ?? 0) == 0)
                            <span class="inicio-estado inicio-amarillo">
                                Sin personal
                            </span>
                        @elseif (($ultimaFicha->cant_conductor ?? 0) == 0)
                            <span class="inicio-estado inicio-celeste">
                                Sin conductores
                            </span>
                        @else
                            <span class="inicio-estado inicio-verde">
                                Operativa
                            </span>
                        @endif
                    </div>

                    <div class="inicio-indicadores">

                        <div class="inicio-indicador">
                            <strong>
                                {{ $ultimaFicha?->cant_personal ?? 0 }}
                            </strong>
                            <span>Personal</span>
                        </div>

                        <div class="inicio-indicador">
                            <strong>
                                {{ $ultimaFicha?->cant_conductor ?? 0 }}
                            </strong>
                            <span>Conductores</span>
                        </div>

                        <div class="inicio-indicador">
                            <strong>
                                {{ $movilesGuardia->where('operativo', true)->count() }}
                            </strong>
                            <span>Móviles operativos</span>
                        </div>

                    </div>

                    <div class="mt-3">
                        <div class="inicio-subtitulo mb-2">
                            Móviles de la condición de guardia
                        </div>

                        <div class="inicio-lista">

                            @forelse ($movilesGuardia as $registroMovil)

                                @php
                                    $movilGuardia = $registroMovil->movil;
                                    $acronimo = $movilGuardia?->acronimo?->tipo ?? '';
                                    $nombreMovil = $movilGuardia?->movil ?? 'Móvil sin nombre';
                                @endphp

                                <div class="inicio-lista-item">
                                    <strong>
                                        {{ trim($acronimo . ' ' . $nombreMovil) }}
                                    </strong>

                                    @if ($registroMovil->operativo)
                                        <span class="inicio-estado inicio-verde">
                                            Operativo
                                        </span>
                                    @else
                                        <span class="inicio-estado inicio-rojo">
                                            Inoperativo
                                        </span>
                                    @endif
                                </div>

                            @empty

                                <div class="inicio-vacio">
                                    No hay móviles declarados en la última condición de guardia.
                                </div>

                            @endforelse

                        </div>
                    </div>

                    <div class="inicio-subtitulo mt-3">
                        Actualizado:
                        {{ $ultimaFicha?->fecha_hora?->format('d/m/Y H:i') ?? 'Sin registro' }}
                    </div>

                @else

                    <div class="inicio-vacio">
                        Tu usuario no tiene una compañía asociada.
                    </div>

                @endif

            </div>
        </div>

        {{-- =====================================================
             MATERIAL MAYOR
        ====================================================== --}}

        <div class="col-xl-4 col-md-6 mb-3">
            <div class="inicio-card">

                <div class="inicio-card-header">
                    <div class="inicio-icono">
                        <i class="fas fa-truck"></i>
                    </div>

                    <div>
                        <h3 class="inicio-titulo">
                            Material Mayor de mi compañía
                        </h3>
                        <div class="inicio-subtitulo">
                            Datos extraídos del módulo Material Mayor
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="inicio-subtitulo">
                        Móviles registrados
                    </span>
                    <strong>{{ $moviles->count() }}</strong>
                </div>

                <div class="inicio-lista">

                    @forelse ($moviles as $movil)

                        <div class="inicio-lista-item">
                            <strong>
                                {{ trim(($movil->acronimo?->tipo ?? '') . ' ' . ($movil->movil ?? '')) }}
                            </strong>

                            {{-- @if ($movil->operativo)
                                <span class="inicio-estado inicio-verde">
                                    Operativo
                                </span>
                            @else
                                <span class="inicio-estado inicio-rojo">
                                    Inoperativo
                                </span>
                            @endif --}}

                            {{-- operatividad_id = 0->INOPERATIVO
                            operatividad_id = 1->OPERATIVO
                            operatividad_id = 2->BAJA --}}
                            @if ($movil->operatividad_id === 1)
                                <span class="inicio-estado inicio-verde">
                                    Operativo
                                </span>
                            @else
                                <span class="inicio-estado inicio-rojo">
                                    Inoperativo
                                </span>
                            @endif
                        </div>

                    @empty

                        <div class="inicio-vacio">
                            No hay móviles disponibles en Material Mayor.
                        </div>

                    @endforelse

                </div>

            </div>
        </div>

        {{-- =====================================================
             SITUACIÓN NACIONAL
             Solo por departamento.
             Compañías seguidas, sin agrupar por ciudad.
        ====================================================== --}}

        <div class="col-xl-4 col-md-12 mb-3">
            <div class="inicio-card">

                <div class="inicio-card-header">
                    <div class="inicio-icono">
                        <i class="fas fa-chart-pie"></i>
                    </div>

                    <div>
                        <h3 class="inicio-titulo">Situación nacional</h3>
                        <div class="inicio-subtitulo">
                            Por departamento · Actualización cada 30 segundos
                        </div>
                    </div>
                </div>

                <div class="inicio-leyenda">
                    <span>
                        <i class="inicio-punto inicio-verde"></i>
                        Operativo
                    </span>

                    <span>
                        <i class="inicio-punto inicio-celeste"></i>
                        Sin conductores
                    </span>

                    <span>
                        <i class="inicio-punto inicio-amarillo"></i>
                        Sin personal
                    </span>

                    <span>
                        <i class="inicio-punto inicio-rojo"></i>
                        Inoperativo
                    </span>
                </div>

                <div class="inicio-nacional-contenido">

                    @forelse ($departamentos as $departamento)

                        <section
                            class="inicio-departamento"
                            wire:key="inicio-departamento-{{ $departamento['id'] }}"
                        >

                            <div class="inicio-departamento-titulo">
                                {{ $departamento['nombre'] }}
                            </div>

                            <div class="inicio-companias-grid">

                                @foreach ($departamento['companias'] as $companiaNacional)

                                    @php
                                        $ficha = $companiaNacional->ultimaOperatividad;
                                        $personalNacional = $ficha?->cant_personal ?? 0;
                                        $conductoresNacional = $ficha?->cant_conductor ?? 0;

                                        if (!$companiaNacional->cca_operativo) {
                                            $claseNacional = 'inicio-rojo';
                                        } elseif ($personalNacional == 0) {
                                            $claseNacional = 'inicio-amarillo';
                                        } elseif ($conductoresNacional == 0) {
                                            $claseNacional = 'inicio-celeste';
                                        } else {
                                            $claseNacional = 'inicio-verde';
                                        }
                                    @endphp

                                    <div
                                        class="inicio-compania {{ $claseNacional }}"
                                        title="{{ $companiaNacional->compania }}"
                                        wire:key="inicio-compania-{{ $companiaNacional->id_compania }}"
                                    >
                                        {{ $companiaNacional->compania }}
                                    </div>

                                @endforeach

                            </div>
                        </section>

                    @empty

                        <div class="inicio-vacio">
                            No hay compañías para mostrar.
                        </div>

                    @endforelse

                </div>
            </div>
        </div>

    </div>
</div>
