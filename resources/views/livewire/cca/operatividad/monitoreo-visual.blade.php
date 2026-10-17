
<div wire:poll.30s class="monitoreo-visual">

    @forelse ($departamentos as $departamento)

        {{-- DEPARTAMENTO --}}
        <section
            class="departamento-section"
            wire:key="departamento-{{ $departamento['id'] }}"
        >
            <div class="departamento-header">
                {{ $departamento['nombre'] }}
            </div>

            {{-- COMPAÑÍAS --}}
            <div class="companias-grid">

                @foreach ($departamento['ciudades'] as $ciudad)

                    @foreach ($ciudad['companias'] as $compania)

                        @php
                            $operatividad = $compania->ultimaOperatividad;

                            $personal = $operatividad?->cant_personal ?? 0;
                            $conductores = $operatividad?->cant_conductor ?? 0;

                            if (!$compania->cca_operativo) {
                                $estadoClase = 'estado-inoperativo';
                            } elseif ($personal == 0) {
                                $estadoClase = 'estado-sin-personal';
                            } elseif ($conductores == 0) {
                                $estadoClase = 'estado-sin-conductores';
                            } else {
                                $estadoClase = 'estado-completo';
                            }
                        @endphp

                        <div
                            class="compania-cuadro {{ $estadoClase }}"
                            wire:key="compania-{{ $compania->id_compania }}"
                            title="{{ $compania->compania }}"
                        >
                            {{ $compania->compania }}
                        </div>

                    @endforeach

                @endforeach

            </div>
        </section>

    @empty

        <div class="alert alert-light border">
            No hay compañías para mostrar.
        </div>

    @endforelse

</div>

@push('css')
<style>
    /* CONTENEDOR GENERAL */
    .monitoreo-visual {
        min-height: 100vh;
        padding: 8px;
        background: #ffffff;
        color: #212529;
    }

    /* DEPARTAMENTOS */
    .departamento-section {
        margin-bottom: 12px;
    }

    .departamento-header {
        margin-bottom: 6px;
        padding: 5px 10px;
        background: #e9ecef;
        border-left: 4px solid #343a40;
        border-radius: 3px;
        color: #212529;
        font-size: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        line-height: 1.2;
    }

    /* CUADRÍCULA: 10 COMPAÑÍAS POR FILA */
    .companias-grid {
        display: grid;
        grid-template-columns: repeat(10, minmax(0, 1fr));
        gap: 5px;
    }

    /* CUADRO DE CADA COMPAÑÍA */
    .compania-cuadro {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 0;
        min-height: 38px;
        padding: 4px;
        border-radius: 4px;
        color: #ffffff;
        text-align: center;
        font-size: 0.78rem;
        line-height: 1.1;
        font-weight: 700;
        overflow-wrap: anywhere;
        word-break: normal;
        box-shadow: none;
    }

    /* ESTADOS OPERATIVOS */
    .compania-cuadro.estado-completo {
        background: #28a745;
        color: #ffffff;
    }

    .compania-cuadro.estado-sin-conductores {
        background: #17a2b8;
        color: #ffffff;
    }

    .compania-cuadro.estado-sin-personal {
        background: #ffc107;
        color: #212529;
    }

    .compania-cuadro.estado-inoperativo {
        background: #dc3545;
        color: #ffffff;
    }

    /* PANTALLAS MEDIANAS */
    @media (max-width: 1100px) {
        .companias-grid {
            grid-template-columns: repeat(7, minmax(0, 1fr));
        }

        .compania-cuadro {
            font-size: 0.74rem;
        }
    }

    /* TABLETS */
    @media (max-width: 800px) {
        .monitoreo-visual {
            padding: 6px;
        }

        .companias-grid {
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 4px;
        }

        .compania-cuadro {
            min-height: 36px;
            font-size: 0.72rem;
        }
    }

    /* MÓVILES */
    @media (max-width: 500px) {
        .companias-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .departamento-header {
            font-size: 0.9rem;
        }
    }
</style>
@endpush
