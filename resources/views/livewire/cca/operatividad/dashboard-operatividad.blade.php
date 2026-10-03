<div>
    {{-- Filtro --}}
    <div class="card card-outline card-primary">
        <div class="card-body py-2">
            <div class="form-row align-items-center">
                <div class="col-md-4">
                    <label class="mb-0 small text-muted">Compañía</label>
                    <select wire:model.live="companiaId" class="form-control form-control-sm">
                        <option value="">Todas las compañías</option>
                        @foreach ($this->companias as $c)
                            <option value="{{ $c->id_compania }}">{{ $c->compania }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8 text-right">
                    <span wire:loading class="text-muted small">
                        <i class="fas fa-spinner fa-spin"></i> Calculando...
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- KPIs --}}
    @php $k = $this->kpis; @endphp
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-{{ $this->color($k['pct7']) }}"><i class="fas fa-percentage"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Operatividad 7 días</span>
                    <span class="info-box-number">{{ $k['pct7'] }}%</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-{{ $this->color($k['pctMes']) }}"><i class="far fa-calendar-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Operatividad del mes</span>
                    <span class="info-box-number">{{ $k['pctMes'] }}%</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-building"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Operativas ahora</span>
                    <span class="info-box-number">{{ $k['operativasAhora'] }} / {{ $k['totalCompanias'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-{{ $this->color($k['pctFlota']) }}"><i class="fas fa-truck"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Flota operativa</span>
                    <span class="info-box-number">{{ $k['pctFlota'] }}%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Gráfico diario --}}
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header"><h3 class="card-title">% de operatividad por día (últimos 7 días)</h3></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between" style="height: 220px;">
                        @foreach ($this->pctPorDia as $d)
                            <div class="flex-fill text-center px-1 d-flex flex-column justify-content-end">
                                <small class="font-weight-bold">{{ $d->pct }}%</small>
                                <div class="d-flex align-items-end" style="height: 150px;">
                                    <div class="w-100 rounded-top bg-{{ $this->color($d->pct) }}"
                                         style="height: {{ $d->pct }}%; min-height: 2px;"></div>
                                </div>
                                <small class="text-muted">{{ $d->dia }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- % por compañía --}}
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header"><h3 class="card-title">% de operatividad por compañía</h3></div>
                <div class="card-body table-responsive p-0" style="max-height: 300px;">
                    <table class="table table-sm table-head-fixed">
                        <thead>
                            <tr>
                                <th>Compañía</th>
                                <th style="width: 32%">Últimos 7 días</th>
                                <th style="width: 32%">Mes actual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->resumen7 as $id => $r7)
                                @php $rm = $this->resumenMes->get($id); @endphp
                                <tr>
                                    <td>{{ $r7->compania }}</td>
                                    <td>
                                        <div class="progress progress-sm mb-1">
                                            <div class="progress-bar bg-{{ $this->color($r7->pct) }}" style="width: {{ $r7->pct }}%"></div>
                                        </div>
                                        <small>{{ $r7->pct }}%</small>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm mb-1">
                                            <div class="progress-bar bg-{{ $this->color($rm->pct) }}" style="width: {{ $rm->pct }}%"></div>
                                        </div>
                                        <small>{{ $rm->pct }}%</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Estado actual --}}
    {{-- <div class="card">
        <div class="card-header"><h3 class="card-title">Estado actual por compañía</h3></div>
        <div class="card-body table-responsive p-0">
            <table class="table table-sm table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Compañía</th>
                        <th>Estado</th>
                        <th>A cargo</th>
                        <th class="text-center">Personal</th>
                        <th class="text-center">Conductores</th>
                        <th class="text-center">Móviles op. (guardia)</th>
                        <th style="width: 15%">Flota operativa</th>
                        <th class="text-center">Hidráulico</th>
                        <th class="text-center">Pileta</th>
                        <th>Último registro</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->estadoActual as $c)
                        @php
                            $o = $c->ultimaOperatividad;
                            $f = $this->flota->get($c->id_compania);
                            $pf = $f && $f->total ? round($f->operativos / $f->total * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td>{{ $c->compania }}</td>
                            <td>
                                @if ($o)
                                    <span class="badge badge-{{ $o->operativo ? 'success' : 'danger' }}">
                                        {{ $o->operativo ? 'Operativa' : 'No operativa' }}
                                    </span>
                                @else
                                    <span class="badge badge-secondary">Sin registro</span>
                                @endif
                            </td>
                            <td>{{ $o?->acargo_rel?->nombrecompleto ?? '-' }}</td>
                            <td class="text-center">{{ $o?->cant_personal ?? '-' }}</td>
                            <td class="text-center">{{ $o?->cant_conductor ?? '-' }}</td>
                            <td class="text-center">
                                @if ($o) {{ $o->moviles->where('operativo', true)->count() }}/{{ $o->moviles->count() }} @else - @endif
                            </td>
                            <td>
                                <div class="progress progress-sm mb-1">
                                    <div class="progress-bar bg-{{ $this->color($pf) }}" style="width: {{ $pf }}%"></div>
                                </div>
                                <small>{{ $pf }}% ({{ $f->operativos ?? 0 }}/{{ $f->total ?? 0 }})</small>
                            </td>
                            <td class="text-center">
                                @if ($o) <i class="fas fa-{{ $o->equipo_hidraulico ? 'check text-success' : 'times text-danger' }}"></i> @endif
                            </td>
                            <td class="text-center">
                                @if ($o) <i class="fas fa-{{ $o->pileta ? 'check text-success' : 'times text-danger' }}"></i> @endif
                            </td>
                            <td>{{ $o?->fecha_hora?->format('d/m/Y H:i') ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}

    <div class="row">
        {{-- Dotación y equipos --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Dotación y equipos (mes)</h3></div>
                <div class="card-body table-responsive p-0" style="max-height: 300px;">
                    <table class="table table-sm table-head-fixed">
                        <thead>
                            <tr>
                                <th>Compañía</th>
                                <th class="text-center">Prom. personal</th>
                                <th class="text-center">Prom. conductores</th>
                                <th class="text-center">% c/ hidráulico</th>
                                <th class="text-center">% c/ pileta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->estadoActual ?? $this->estadoActual as $c)
                                @php $p = $this->promediosMes->get($c->id_compania); @endphp
                                <tr>
                                    <td>{{ $c->compania }}</td>
                                    @if ($p)
                                        <td class="text-center">{{ number_format($p->prom_personal, 0) }}</td>
                                        <td class="text-center">{{ number_format($p->prom_conductor, 0) }}</td>
                                        <td class="text-center">{{ round($p->con_hidraulico / max($p->registros, 1) * 100) }}%</td>
                                        <td class="text-center">{{ round($p->con_pileta / max($p->registros, 1) * 100) }}%</td>
                                    @else
                                        <td colspan="4" class="text-center text-muted">Sin registros</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Móviles problemáticos --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Móviles con más reportes fuera de servicio (mes)</h3></div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse ($this->movilesProblematicos as $m)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $this->nombreMovil($m->movil) }}</strong>
                                    <span class="text-danger">{{ $m->pct }}% ({{ $m->fuera }}/{{ $m->total }})</span>
                                </div>
                                <div class="progress progress-xs mt-1">
                                    <div class="progress-bar bg-danger" style="width: {{ $m->pct }}%"></div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Sin novedades este mes.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Móviles inoperativos actuales --}}
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title">Móviles inoperativos actualmente (Datos del Módulo de Materiales)</h3>
            <div class="card-tools"><span class="badge badge-danger">{{ $this->movilesInoperativos->count() }}</span></div>
        </div>
        <div class="card-body table-responsive p-0" style="max-height: 320px;">
            <table class="table table-sm table-head-fixed">
                <thead>
                    <tr><th>Compañía</th><th>Móvil</th><th>Motivo</th><th>Detalle</th><th>Desde</th></tr>
                </thead>
                <tbody>
                    @forelse ($this->movilesInoperativos as $m)
                        @php $com = $m->ultimoComentarioFueraServicio; @endphp
                        <tr>
                            <td>{{ $m->compania?->compania }}</td>
                            <td>{{ $this->nombreMovil($m) }}</td>
                            <td>{{ $com?->motivo?->categoria ?? '-' }}</td>
                            <td>{{ $com?->detalle?->detalle ?? '-' }}</td>
                            <td>{{ $com?->created_at?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">No hay móviles inoperativos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>