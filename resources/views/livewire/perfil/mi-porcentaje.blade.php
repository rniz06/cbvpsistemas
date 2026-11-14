
<div>
    {{-- FILTROS --}}
    <div class="card card-outline card-warning mb-3">
        <div class="card-header py-2">
            <h3 class="card-title">
                <i class="fas fa-percentage mr-1"></i>
                Mi porcentaje de asistencia
            </h3>
        </div>

        <div class="card-body py-2">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="mb-1">Año</label>

                        <select
                            class="form-control form-control-sm"
                            wire:model.live="anioSeleccionado"
                        >
                            <option value="">Seleccioná un año</option>

                            @foreach ($anios as $anio)
                                <option value="{{ $anio->id_anho }}">
                                    {{ $anio->anho }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-2">
                        <label class="mb-1">Período desde</label>

                        <select
                            class="form-control form-control-sm"
                            wire:model.live="periodoDesde"
                        >
                            @for ($mes = 1; $mes <= 12; $mes++)
                                <option value="{{ $mes }}">
                                    {{ \Carbon\Carbon::create()->month($mes)->locale('es')->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-2">
                        <label class="mb-1">Período hasta</label>

                        <select
                            class="form-control form-control-sm"
                            wire:model.live="periodoHasta"
                        >
                            @for ($mes = 1; $mes <= 12; $mes++)
                                <option value="{{ $mes }}">
                                    {{ \Carbon\Carbon::create()->month($mes)->locale('es')->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="col-md-2 mb-2">
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-secondary btn-block"
                        wire:click="$refresh"
                    >
                        <i class="fas fa-sync-alt"></i>
                        Actualizar
                    </button>
                </div>
            </div>

            <small class="text-muted">
                Se muestran únicamente los períodos donde tenés un detalle
                individual registrado, respetando tu categoría histórica P4/P5.
            </small>
        </div>
    </div>

    {{-- SIN AÑOS DISPONIBLES --}}
    @if ($anios->isEmpty())
        <div class="alert alert-info mb-3">
            <i class="fas fa-info-circle"></i>
            No se encontraron registros individuales de asistencia asociados
            a tu ficha.
        </div>

    {{-- AÑO NO SELECCIONADO --}}
    @elseif ($anioSeleccionado === '')
        <div class="alert alert-info mb-3">
            Seleccioná un año para consultar tus porcentajes.
        </div>

    @else

        {{-- RESUMEN --}}
        <div class="row mb-3">

            <div class="col-md-4 col-12 mb-2">
                <div class="small-box bg-success mb-0">
                    <div class="inner">
                        <h3>
                            {{ $promedio !== null
                                ? number_format($promedio, 2, ',', '.') . '%'
                                : '—' }}
                        </h3>
                        <p>Promedio del período seleccionado</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-6 mb-2">
                <div class="small-box bg-info mb-0">
                    <div class="inner">
                        <h3>{{ $cantidadPeriodos }}</h3>
                        <p>Períodos encontrados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-6 mb-2">
                <div class="small-box bg-secondary mb-0">
                    <div class="inner">
                        <h3>{{ $cantidadConPorcentaje }}</h3>
                        <p>Porcentajes calculados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- TABLA DE PORCENTAJES --}}
        <div class="card mb-0">
            <div class="card-header py-2">
                <h3 class="card-title">
                    <i class="fas fa-list-alt mr-1"></i>
                    Mis porcentajes por período
                </h3>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover mb-0">

                        <thead class="thead-light">
                            <tr>
                                <th>Año</th>
                                <th>Período</th>
                                <th>Tipo</th>
                                <th>Práctica</th>
                                <th>Guardia</th>
                                <th>Citación</th>
                                <th>Total</th>
                                <th>Estado de planilla</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($registros as $registro)

                                @php
                                    $estado = $registro->estado_planilla ?? 'SIN ESTADO';

                                    $claseEstado = match ($estado) {
                                        'NO INICIADO' => 'badge badge-secondary',
                                        'SIN CARGAR' => 'badge badge-warning',
                                        'REMITIDO P/ VERIFICAR' => 'badge badge-info',
                                        'APROBADO POR PERSONAL' => 'badge badge-success',
                                        'RECHAZADO POR PERSONAL' => 'badge badge-danger',
                                        default => 'badge badge-light',
                                    };
                                @endphp

                                <tr wire:key="mi-porcentaje-{{ $registro->id_asistencia_detalle }}">

                                    <td>
                                        {{ $registro->anho }}
                                    </td>

                                    <td class="text-capitalize">
                                        {{ $registro->mes }}
                                    </td>

                                    <td>
                                        @if ($registro->tipo_asistencia === 'P4')
                                            <span class="badge badge-primary">
                                                P4 - Combatiente
                                            </span>
                                        @elseif ($registro->tipo_asistencia === 'P5')
                                            <span class="badge badge-info">
                                                P5 - Activo
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                {{ $registro->tipo_asistencia ?? 'N/A' }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($registro->practica !== null)
                                            {{ number_format((float) $registro->practica, 2, ',', '.') }}%
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($registro->guardia !== null)
                                            {{ number_format((float) $registro->guardia, 2, ',', '.') }}%
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($registro->citacion !== null)
                                            {{ number_format((float) $registro->citacion, 2, ',', '.') }}%
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($registro->total !== null)
                                            <strong>
                                                {{ number_format((float) $registro->total, 2, ',', '.') }}%
                                            </strong>
                                        @else
                                            <span class="text-muted">
                                                Sin calcular
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="{{ $claseEstado }}">
                                            {{ $estado }}
                                        </span>

                                        @if ($registro->total === null)
                                            <br>
                                            <small class="text-muted">
                                                Sin porcentaje calculado
                                            </small>
                                        @endif
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        No se encontraron porcentajes individuales
                                        para el año y rango de períodos seleccionado.
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>

                        @if ($registros->isNotEmpty())
                            <tfoot class="thead-light">
                                <tr>
                                    <th colspan="6" class="text-right">
                                        Promedio del rango seleccionado:
                                    </th>

                                    <th>
                                        @if ($promedio !== null)
                                            <span class="text-success font-weight-bold">
                                                {{ number_format($promedio, 2, ',', '.') }}%
                                            </span>
                                        @else
                                            —
                                        @endif
                                    </th>

                                    <th>
                                        <small class="text-muted">
                                            {{ $cantidadConPorcentaje }}
                                            registro(s) con total calculado
                                        </small>
                                    </th>
                                </tr>
                            </tfoot>
                        @endif

                    </table>
                </div>
            </div>
        </div>

    @endif
</div>
