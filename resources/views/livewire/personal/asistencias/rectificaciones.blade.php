<div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="card card-outline card-primary">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit mr-2"></i>
                Rectificaciones de asistencias
            </h3>
        </div>

        <div class="card-body">

            {{-- BUSCAR BOMBERO --}}
            @if (!$personalSeleccionadoId)

                <div class="form-group">
                    <label>Buscar bombero</label>

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Ingresá el código o nombre del bombero..."
                        wire:model.live.debounce.400ms="buscar"
                    >

                    <small class="form-text text-muted">
                        Escribí al menos dos caracteres para iniciar la búsqueda.
                    </small>
                </div>

                @if (mb_strlen(trim($buscar)) >= 2)

                    @if ($personalEncontrado->count())

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">

                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre completo</th>
                                        <th>Compañía</th>
                                        <th width="110">Acción</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($personalEncontrado as $persona)
                                        <tr>
                                            <td>{{ $persona->codigo }}</td>

                                            <td>
                                                {{ $persona->nombrecompleto }}
                                            </td>

                                            <td>
                                                {{ $persona->compania?->compania ?? 'Sin compañía asignada' }}
                                            </td>

                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-primary"
                                                    wire:click="seleccionarPersonal({{ $persona->idpersonal }})"
                                                >
                                                    <i class="fas fa-user-check"></i>
                                                    Seleccionar
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    @else

                        <div class="alert alert-warning">
                            No se encontraron bomberos con ese código o nombre.
                        </div>

                    @endif

                @endif

            @else

                {{-- FICHA DEL BOMBERO --}}
                <div class="card card-outline card-info">

                    <div class="card-header">

                        <h3 class="card-title">
                            <i class="fas fa-user mr-2"></i>
                            Ficha del bombero
                        </h3>

                        <div class="card-tools">
                            <button
                                type="button"
                                class="btn btn-sm btn-secondary"
                                wire:click="cambiarPersonal"
                            >
                                <i class="fas fa-search mr-1"></i>
                                Buscar otro
                            </button>
                        </div>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4">
                                <strong>Código:</strong>
                                {{ $personal->codigo }}
                            </div>

                            <div class="col-md-8">
                                <strong>Nombre:</strong>
                                {{ $personal->nombrecompleto }}
                            </div>

                            <div class="col-md-4 mt-2">
                                <strong>Compañía:</strong>
                                {{ $personal->compania?->compania ?? 'Sin compañía asignada' }}
                            </div>

                        </div>

                    </div>
                </div>

                {{-- LISTADO DE ASISTENCIAS --}}
                <h5 class="mb-3">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Asistencias aprobadas
                </h5>

                @if ($detalles->count())

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <thead class="thead-light">
                                <tr>
                                    <th>Período</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Práctica</th>
                                    <th>Guardia</th>
                                    <th>Citación</th>
                                    <th>Total</th>
                                    <th width="130">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($detalles as $detalle)

                                    <tr>
                                        <td>
                                            {{ $detalle->asistencia?->periodo?->mes?->mes ?? '-' }}
                                            /
                                            {{ $detalle->asistencia?->periodo?->anho?->anho ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $detalle->asistencia?->tipo_asistencia ?? '-' }}
                                        </td>

                                        <td>
                                            <span class="badge badge-success">
                                                {{ $detalle->asistencia?->estado?->estado ?? 'Aprobada' }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $detalle->practica ?? '-' }}%
                                        </td>

                                        <td>
                                            {{ $detalle->guardia ?? '-' }}%
                                        </td>

                                        <td>
                                            {{ $detalle->citacion ?? '-' }}%
                                        </td>

                                        <td>
                                            <strong>
                                                {{ $detalle->total ?? 0 }}%
                                            </strong>
                                        </td>

                                        <td>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-warning mb-1"
                                                wire:click="editar({{ $detalle->id_asistencia_detalle }})"
                                            >
                                                <i class="fas fa-edit"></i>
                                                Modificar
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-info"
                                                wire:click="verHistorial({{ $detalle->id_asistencia_detalle }})"
                                            >
                                                <i class="fas fa-history"></i>
                                                Historial
                                            </button>

                                        </td>
                                    </tr>

                                    {{-- FORMULARIO DE RECTIFICACIÓN --}}
                                    @if (
                                        $detalleEnEdicionId ==
                                        $detalle->id_asistencia_detalle
                                    )

                                        <tr>
                                            <td colspan="8">

                                                <div class="card card-outline card-warning mb-0">

                                                    <div class="card-header">
                                                        <h3 class="card-title">
                                                            Rectificar asistencia
                                                            - {{ $detalle->asistencia?->tipo_asistencia }}
                                                        </h3>
                                                    </div>

                                                    <div class="card-body">

                                                        <div class="row">

                                                            @if (
                                                                $detalle->asistencia?->tipo_asistencia !== 'P5'
                                                            )

                                                                <div class="col-md-4">
                                                                    <div class="form-group">

                                                                        <label>
                                                                            Práctica (%)
                                                                        </label>

                                                                        <input
                                                                            type="number"
                                                                            min="0"
                                                                            max="100"
                                                                            step="0.01"
                                                                            class="form-control"
                                                                            wire:model="practica"
                                                                        >

                                                                        @error('practica')
                                                                            <small class="text-danger">
                                                                                {{ $message }}
                                                                            </small>
                                                                        @enderror

                                                                    </div>
                                                                </div>

                                                            @endif

                                                            <div class="col-md-4">
                                                                <div class="form-group">

                                                                    <label>
                                                                        Guardia (%)
                                                                    </label>

                                                                    <input
                                                                        type="number"
                                                                        min="0"
                                                                        max="100"
                                                                        step="0.01"
                                                                        class="form-control"
                                                                        wire:model="guardia"
                                                                    >

                                                                    @error('guardia')
                                                                        <small class="text-danger">
                                                                            {{ $message }}
                                                                        </small>
                                                                    @enderror

                                                                </div>
                                                            </div>

                                                            @if ($detalle->asistencia?->hubo_citacion)

                                                                <div class="col-md-4">
                                                                    <div class="form-group">

                                                                        <label>
                                                                            Citación (%)
                                                                        </label>

                                                                        <input
                                                                            type="number"
                                                                            min="0"
                                                                            max="100"
                                                                            step="0.01"
                                                                            class="form-control"
                                                                            wire:model="citacion"
                                                                        >

                                                                        @error('citacion')
                                                                            <small class="text-danger">
                                                                                {{ $message }}
                                                                            </small>
                                                                        @enderror

                                                                    </div>
                                                                </div>

                                                            @endif

                                                            <div class="col-md-12">

                                                                <div class="form-group">

                                                                    <label>
                                                                        Motivo / Observación de la rectificación
                                                                    </label>

                                                                    <textarea
                                                                        class="form-control"
                                                                        rows="3"
                                                                        maxlength="1000"
                                                                        wire:model="observacion"
                                                                        placeholder="Explicá por qué se realiza esta rectificación..."
                                                                    ></textarea>

                                                                    @error('observacion')
                                                                        <small class="text-danger">
                                                                            {{ $message }}
                                                                        </small>
                                                                    @enderror

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="alert alert-info">
                                                            <i class="fas fa-info-circle mr-1"></i>
                                                            El promedio se recalculará automáticamente.
                                                            La modificación quedará registrada en el historial.
                                                        </div>

                                                        <button
                                                            type="button"
                                                            class="btn btn-success"
                                                            wire:click="guardar"
                                                            wire:loading.attr="disabled"
                                                        >
                                                            <span wire:loading.remove wire:target="guardar">
                                                                <i class="fas fa-save mr-1"></i>
                                                                Guardar rectificación
                                                            </span>

                                                            <span wire:loading wire:target="guardar">
                                                                Guardando...
                                                            </span>
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="btn btn-secondary"
                                                            wire:click="cancelarEdicion"
                                                        >
                                                            Cancelar
                                                        </button>

                                                    </div>

                                                </div>

                                            </td>
                                        </tr>

                                    @endif

                                    {{-- HISTORIAL DE RECTIFICACIONES --}}
                                    @if (
                                        $detalleHistorialId ==
                                        $detalle->id_asistencia_detalle
                                    )

                                        <tr>
                                            <td colspan="8">

                                                <div class="card card-outline card-info">

                                                    <div class="card-header">

                                                        <h3 class="card-title">
                                                            <i class="fas fa-history mr-1"></i>
                                                            Historial de rectificaciones
                                                        </h3>

                                                        <div class="card-tools">
                                                            <button
                                                                type="button"
                                                                class="btn btn-sm btn-secondary"
                                                                wire:click="cerrarHistorial"
                                                            >
                                                                Cerrar
                                                            </button>
                                                        </div>

                                                    </div>

                                                    <div class="card-body">

                                                        @forelse ($historiales as $registro)

                                                            @php
                                                                $anteriores = json_decode(
                                                                    $registro->valores_anteriores,
                                                                    true
                                                                ) ?? [];

                                                                $nuevos = json_decode(
                                                                    $registro->valores_nuevos,
                                                                    true
                                                                ) ?? [];
                                                            @endphp

                                                            <div class="border rounded p-3 mb-3">

                                                                <div class="row">

                                                                    <div class="col-md-6">
                                                                        <strong>Fecha:</strong>

                                                                        {{ \Carbon\Carbon::parse(
                                                                            $registro->created_at
                                                                        )->format('d/m/Y H:i:s') }}
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <strong>Usuario ID:</strong>

                                                                        {{ $registro->usuario_id ?? 'No disponible' }}
                                                                    </div>

                                                                </div>

                                                                <div class="mt-2">
                                                                    <strong>Observación:</strong>

                                                                    <p class="mb-2">
                                                                        {{ $registro->observacion }}
                                                                    </p>
                                                                </div>

                                                                <div class="table-responsive">

                                                                    <table class="table table-sm table-bordered">

                                                                        <thead>
                                                                            <tr>
                                                                                <th>Campo</th>
                                                                                <th>Valor anterior</th>
                                                                                <th>Valor nuevo</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>

                                                                            @foreach (
                                                                                ['practica', 'guardia', 'citacion', 'total']
                                                                                as $campo
                                                                            )

                                                                                <tr>
                                                                                    <td>
                                                                                        {{ ucfirst($campo) }}
                                                                                    </td>

                                                                                    <td>
                                                                                        {{ $anteriores[$campo] ?? '-' }}
                                                                                    </td>

                                                                                    <td>
                                                                                        <strong>
                                                                                            {{ $nuevos[$campo] ?? '-' }}
                                                                                        </strong>
                                                                                    </td>
                                                                                </tr>

                                                                            @endforeach

                                                                        </tbody>

                                                                    </table>

                                                                </div>

                                                            </div>

                                                        @empty

                                                            <div class="alert alert-info">
                                                                Todavía no existen rectificaciones para esta asistencia.
                                                            </div>

                                                        @endforelse

                                                    </div>

                                                </div>

                                            </td>
                                        </tr>

                                    @endif

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="alert alert-warning">
                        Este bombero no tiene asistencias correspondientes a planillas aprobadas.
                    </div>

                @endif

            @endif

        </div>
    </div>
</div>