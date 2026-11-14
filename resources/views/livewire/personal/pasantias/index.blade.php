
<div>
    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h5 class="mb-0">Pasantías de Personal</h5>
            <small class="text-muted">Gestión y seguimiento de pasantías</small>
        </div>

        @can('Personal Pasantias Crear')
            <button type="button" class="btn btn-sm btn-primary" wire:click="abrirFormulario">
                <i class="fas fa-plus"></i> Nueva pasantía
            </button>
        @endcan
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success py-2 mb-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger py-2 mb-2">
            <strong>Revisá los siguientes datos:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TARJETAS COMPACTAS --}}
    <div class="row mb-2">

        <div class="col-xl-3 col-md-6 col-6 mb-2">
            <button type="button"
                class="card bg-danger text-white w-100 mb-0 shadow-sm text-left border-0"
                style="cursor:pointer;"
                wire:click="filtrarPorEstado('VENCIDA_7_DIAS')">
                <div class="card-body py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-uppercase font-weight-bold">Vencidas</small>
                            <h3 class="mb-0 font-weight-bold">{{ $totalVencidas }}</h3>
                            <small>Últimos 7 días</small>
                        </div>
                        <i class="fas fa-exclamation-circle fa-2x"></i>
                    </div>
                </div>
                <div class="card-footer py-1 px-3 text-white">
                    <small>Ver vencidas</small>
                    <i class="fas fa-arrow-circle-right float-right mt-1"></i>
                </div>
            </button>
        </div>

        <div class="col-xl-3 col-md-6 col-6 mb-2">
            <button type="button"
                class="card bg-warning text-dark w-100 mb-0 shadow-sm text-left border-0"
                style="cursor:pointer;"
                wire:click="filtrarPorEstado('POR_VENCER_7_DIAS')">
                <div class="card-body py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-uppercase font-weight-bold">Por vencer</small>
                            <h3 class="mb-0 font-weight-bold">{{ $totalPorVencer }}</h3>
                            <small>Próximos 7 días</small>
                        </div>
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
                <div class="card-footer py-1 px-3 text-dark">
                    <small>Ver próximas finalizaciones</small>
                    <i class="fas fa-arrow-circle-right float-right mt-1"></i>
                </div>
            </button>
        </div>

        <div class="col-xl-3 col-md-6 col-6 mb-2">
            <button type="button"
                class="card bg-success text-white w-100 mb-0 shadow-sm text-left border-0"
                style="cursor:pointer;"
                wire:click="filtrarPorEstado('VIGENTE')">
                <div class="card-body py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-uppercase font-weight-bold">Vigentes</small>
                            <h3 class="mb-0 font-weight-bold">{{ $totalVigentes }}</h3>
                            <small>Actualmente activas</small>
                        </div>
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
                <div class="card-footer py-1 px-3 text-white">
                    <small>Ver vigentes</small>
                    <i class="fas fa-arrow-circle-right float-right mt-1"></i>
                </div>
            </button>
        </div>

        <div class="col-xl-3 col-md-6 col-6 mb-2">
            <button type="button"
                class="card bg-secondary text-white w-100 mb-0 shadow-sm text-left border-0"
                style="cursor:pointer;"
                wire:click="filtrarPorEstado('')">
                <div class="card-body py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-uppercase font-weight-bold">Total pasantías</small>
                            <h3 class="mb-0 font-weight-bold">{{ $totalPasantias }}</h3>
                            <small>Todos los registros</small>
                        </div>
                        <i class="fas fa-layer-group fa-2x"></i>
                    </div>
                </div>
                <div class="card-footer py-1 px-3 text-white">
                    <small>Ver todos</small>
                    <i class="fas fa-arrow-circle-right float-right mt-1"></i>
                </div>
            </button>
        </div>

    </div>

    {{-- FORMULARIO --}}
    @if ($mostrarFormulario)
        <div class="card card-primary card-outline mb-2">
            <div class="card-header py-2">
                <h3 class="card-title text-sm">
                    <i class="fas fa-calendar-alt"></i> Registrar nueva pasantía
                </h3>
            </div>

            <form wire:submit="guardar">
                <div class="card-body py-2">
                    <div class="alert alert-info py-2 mb-2">
                        <small>
                            La compañía de origen se obtiene de la ficha del bombero
                            y no será modificada.
                        </small>
                    </div>

                    <div class="form-group mb-2">
                        <label class="mb-1">Buscar bombero</label>

                        @if (!$personalSeleccionadoId)
                            <input type="text"
                                class="form-control form-control-sm"
                                wire:model.live.debounce.400ms="buscarPersonal"
                                placeholder="Código, cédula o nombre..."
                                autocomplete="off">

                            @error('personalSeleccionadoId')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            @if (mb_strlen(trim($buscarPersonal)) >= 2)
                                <div class="table-responsive mt-2">
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Cédula</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($resultadosPersonal as $resultado)
                                                <tr>
                                                    <td>{{ $resultado->codigo }}</td>
                                                    <td>{{ $resultado->nombrecompleto }}</td>
                                                    <td>{{ $resultado->documento }}</td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-xs btn-primary"
                                                            wire:click="seleccionarPersonal({{ $resultado->idpersonal }})">
                                                            Seleccionar
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        No se encontraron bomberos.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-success py-2 mb-0">
                                <i class="fas fa-user-check"></i>
                                <strong>{{ $buscarPersonal }}</strong>

                                <button type="button"
                                    class="btn btn-xs btn-outline-secondary ml-2"
                                    wire:click="quitarPersonal">
                                    Cambiar
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="form-group mb-2">
                        <label class="mb-1">Compañía de origen</label>
                        <input type="text"
                            class="form-control form-control-sm"
                            value="{{ $nombreCompaniaOrigen ?? '' }}"
                            readonly>
                    </div>

                    <div class="form-group mb-2">
                        <label class="mb-1">Compañía de destino</label>
                        <select class="form-control form-control-sm"
                            wire:model="companiaDestinoId">
                            <option value="">Seleccioná la compañía de destino</option>
                            @foreach ($companias as $compania)
                                <option value="{{ $compania->id_compania }}">
                                    {{ $compania->compania }}
                                </option>
                            @endforeach
                        </select>
                        @error('companiaDestinoId')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="mb-1">Fecha de inicio</label>
                                <input type="date"
                                    class="form-control form-control-sm"
                                    wire:model="fechaInicio">
                                @error('fechaInicio')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="mb-1">Fecha de fin</label>
                                <input type="date"
                                    class="form-control form-control-sm"
                                    wire:model="fechaFin">
                                @error('fechaFin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="mb-1">Observaciones</label>
                        <textarea class="form-control form-control-sm"
                            rows="2"
                            wire:model="observaciones"
                            maxlength="5000"
                            placeholder="Observaciones..."></textarea>
                        @error('observaciones')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="card-footer py-2">
                    <button type="submit"
                        class="btn btn-sm btn-success"
                        wire:loading.attr="disabled"
                        wire:target="guardar">
                        <span wire:loading.remove wire:target="guardar">
                            <i class="fas fa-save"></i> Guardar
                        </span>
                        <span wire:loading wire:target="guardar">
                            Guardando...
                        </span>
                    </button>

                    <button type="button"
                        class="btn btn-sm btn-secondary"
                        wire:click="cerrarFormulario">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- LISTADO --}}
    <div class="card mb-2">
        <div class="card-header py-2">
            <h3 class="card-title text-sm">
                <i class="fas fa-list"></i> Listado de pasantías
            </h3>
        </div>

        <div class="card-body py-2">

            {{-- FILTROS --}}
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="form-group mb-2">
                        <label class="mb-1">Buscar bombero o compañía</label>
                        <input type="text"
                            class="form-control form-control-sm"
                            wire:model.live.debounce.400ms="buscar"
                            placeholder="Código, cédula, nombre, compañía...">
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="form-group mb-2">
                        <label class="mb-1">Compañía</label>
                        <select class="form-control form-control-sm"
                            wire:model.live="filtroCompania">
                            <option value="">Todas las compañías</option>
                            @foreach ($companias as $compania)
                                <option value="{{ $compania->id_compania }}">
                                    {{ $compania->compania }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="form-group mb-2">
                        <label class="mb-1">Estado</label>
                        <select class="form-control form-control-sm"
                            wire:model.live="filtroEstado">
                            <option value="">Todos</option>
                            <option value="PENDIENTE">Pendiente</option>
                            <option value="VIGENTE">Vigente</option>
                            <option value="VENCIDA">Todas las vencidas</option>
                            <option value="VENCIDA_7_DIAS">Vencidas últimos 7 días</option>
                            <option value="POR_VENCER_7_DIAS">Por vencer próximos 7 días</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="form-group mb-2">
                        <label class="mb-1">Registros por página</label>
                        <select class="form-control form-control-sm"
                            wire:model.live="paginado">
                            <option value="10">10 registros</option>
                            <option value="25">25 registros</option>
                            <option value="50">50 registros</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row align-items-end">
                <div class="col-md-3">
                    <div class="form-group mb-2">
                        <label class="mb-1">Inicio desde</label>
                        <input type="date"
                            class="form-control form-control-sm"
                            wire:model.live="filtroFechaInicio">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-2">
                        <label class="mb-1">Fin hasta</label>
                        <input type="date"
                            class="form-control form-control-sm"
                            wire:model.live="filtroFechaFin">
                    </div>
                </div>

                <div class="col-md-3 mb-2">
                    <button type="button"
                        class="btn btn-sm btn-outline-secondary"
                        wire:click="limpiarFiltros">
                        <i class="fas fa-eraser"></i> Limpiar filtros
                    </button>
                </div>
            </div>

            @if ($filtroEstado !== '')
                <div class="alert alert-light border py-1 px-2 mb-2">
                    <small>
                        <i class="fas fa-filter"></i>
                        Filtro activo:

                        <strong>
                            @switch($filtroEstado)
                                @case('VENCIDA_7_DIAS')
                                    Vencidas en los últimos 7 días
                                    @break
                                @case('POR_VENCER_7_DIAS')
                                    Por vencer en los próximos 7 días
                                    @break
                                @case('VENCIDA')
                                    Todas las vencidas
                                    @break
                                @case('VIGENTE')
                                    Pasantías vigentes
                                    @break
                                @case('PENDIENTE')
                                    Pasantías pendientes
                                    @break
                            @endswitch
                        </strong>

                        <button type="button"
                            class="btn btn-xs btn-link py-0"
                            wire:click="filtrarPorEstado('')">
                            Quitar filtro
                        </button>
                    </small>
                </div>
            @endif

            {{-- TABLA --}}
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover mb-2">
                    <thead class="thead-light">
                        <tr>
                            <th>Bombero</th>
                            <th>Código</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estado</th>
                            <th>Registrado por</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pasantias as $pasantia)
                            @php
                                $estado = $pasantia->estado_calculado;

                                $claseEstado = match ($estado) {
                                    'PENDIENTE' => 'badge badge-info',
                                    'VIGENTE' => 'badge badge-success',
                                    'VENCIDA' => 'badge badge-danger',
                                    default => 'badge badge-secondary',
                                };

                                $diasRestantes = (int) now()
                                    ->startOfDay()
                                    ->diffInDays(
                                        $pasantia->fecha_fin->copy()->startOfDay(),
                                        false
                                    );
                            @endphp

                            <tr wire:key="pasantia-{{ $pasantia->id_pasantia }}">
                                <td>{{ $pasantia->personal->nombrecompleto ?? 'Ficha no disponible' }}</td>
                                <td>{{ $pasantia->personal->codigo ?? 'N/A' }}</td>
                                <td>{{ $pasantia->companiaOrigen->compania ?? 'N/A' }}</td>
                                <td>{{ $pasantia->companiaDestino->compania ?? 'N/A' }}</td>
                                <td>{{ $pasantia->fecha_inicio->format('d/m/Y') }}</td>
                                <td>{{ $pasantia->fecha_fin->format('d/m/Y') }}</td>

                                <td>
                                    <span class="{{ $claseEstado }}">{{ $estado }}</span>

                                    @if ($estado === 'VENCIDA')
                                        <br>
                                        <small class="text-danger font-weight-bold">
                                            Venció hace {{ abs($diasRestantes) }}
                                            {{ abs($diasRestantes) === 1 ? 'día' : 'días' }}
                                        </small>
                                    @elseif ($estado === 'VIGENTE' && $diasRestantes <= 7)
                                        <br>
                                        <small class="text-warning font-weight-bold">
                                            @if ($diasRestantes === 0)
                                                Vence hoy
                                            @else
                                                Vence en {{ $diasRestantes }}
                                                {{ $diasRestantes === 1 ? 'día' : 'días' }}
                                            @endif
                                        </small>
                                    @endif
                                </td>

                                <td>
                                    {{ $pasantia->registradoPor?->personal?->nombrecompleto ?? 'No disponible' }}
                                </td>

                                <td>{{ $pasantia->observaciones ?: '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-3">
                                    <i class="fas fa-info-circle"></i>
                                    No hay pasantías que coincidan con los filtros.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $pasantias->links() }}
            </div>
        </div>
    </div>
</div>
