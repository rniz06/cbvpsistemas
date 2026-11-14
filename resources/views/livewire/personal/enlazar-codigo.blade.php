<div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-link mr-1"></i>
                Enlazar código anterior
            </h3>
        </div>

        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="alert alert-info">
                <strong>Importante:</strong>
                este proceso relaciona dos fichas independientes.
                No se trasladan asistencias, resoluciones ni otros
                registros de una ficha a la otra.
            </div>

            <h5>Ficha nueva</h5>

            <div class="row">
                <div class="col-md-4">
                    <label>Código</label>
                    <p class="form-control">
                        {{ $destino->codigo }}
                    </p>
                </div>

                <div class="col-md-8">
                    <label>Nombre completo</label>
                    <p class="form-control">
                        {{ $destino->nombrecompleto }}
                    </p>
                </div>
            </div>

            <hr>

            <h5>Buscar ficha anterior</h5>

            <div class="form-group">
                <label for="busqueda">
                    Buscar por nombre, código o documento
                </label>

                <input
                    id="busqueda"
                    type="text"
                    class="form-control"
                    wire:model.live.debounce.400ms="busqueda"
                    placeholder="Escribí al menos 2 caracteres..."
                    autocomplete="off"
                >

                @error('personalAnteriorId')
                    <small class="text-danger d-block mt-2">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div wire:loading wire:target="busqueda" class="text-muted mb-2">
                Buscando fichas...
            </div>

            @if (mb_strlen(trim($busqueda)) >= 2)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre completo</th>
                                <th>Documento</th>
                                <th>Categoría</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($resultados as $resultado)
                                <tr>
                                    <td>{{ $resultado->codigo }}</td>
                                    <td>{{ $resultado->nombrecompleto }}</td>
                                    <td>{{ $resultado->documento ?? 'N/A' }}</td>
                                    <td>{{ $resultado->categoria ?? 'N/A' }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary"
                                            wire:click="seleccionarAnterior({{ $resultado->idpersonal }})"
                                            wire:loading.attr="disabled"
                                        >
                                            <i class="fas fa-check"></i>
                                            Seleccionar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No se encontraron fichas disponibles.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($fichaAnterior)
                <hr>

                <div class="alert alert-warning">
                    <h5>
                        <i class="fas fa-user-clock"></i>
                        Ficha anterior seleccionada
                    </h5>

                    <p>
                        <strong>Código:</strong>
                        {{ $fichaAnterior->codigo }}
                    </p>

                    <p>
                        <strong>Nombre:</strong>
                        {{ $fichaAnterior->nombrecompleto }}
                    </p>

                    <p>
                        <strong>Estado actual:</strong>
                        {{ $fichaAnterior->estado->estado ?? 'N/A' }}
                    </p>

                    <p class="mb-0">
                        Al confirmar, esta ficha pasará a estado
                        <strong>ENLAZADO</strong> y su usuario perderá
                        el acceso al sistema.
                    </p>
                </div>

                {{-- Observaciones propias de este enlace --}}
                <div class="form-group">
                    <label for="observaciones">
                        Observaciones del enlace (opcional)
                    </label>

                    <textarea
                        id="observaciones"
                        class="form-control"
                        rows="4"
                        maxlength="5000"
                        wire:model="observaciones"
                        placeholder="Escribí aquí las observaciones correspondientes a este enlace..."
                    ></textarea>

                    <small class="form-text text-muted">
                        Estas observaciones quedarán asociadas únicamente
                        a este enlace. Máximo 5.000 caracteres.
                    </small>

                    @error('observaciones')
                        <small class="text-danger d-block">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                @if (!$mostrarConfirmacion)
                    <button
                        type="button"
                        class="btn btn-success"
                        wire:click="prepararEnlace"
                    >
                        <i class="fas fa-link"></i>
                        Continuar
                    </button>
                @else
                    <div class="alert alert-danger">
                        <h5>¿Confirmás el enlace?</h5>

                        <p>
                            Revisá cuidadosamente ambos códigos y nombres.
                            Esta operación cambia el estado de la ficha
                            anterior y bloquea su usuario.
                        </p>

                        <button
                            type="button"
                            class="btn btn-danger"
                            wire:click="enlazar"
                            wire:loading.attr="disabled"
                            wire:target="enlazar"
                        >
                            <span wire:loading.remove wire:target="enlazar">
                                Sí, enlazar fichas
                            </span>

                            <span wire:loading wire:target="enlazar">
                                Procesando...
                            </span>
                        </button>

                        <button
                            type="button"
                            class="btn btn-secondary"
                            wire:click="cancelarEnlace"
                            wire:loading.attr="disabled"
                        >
                            Cancelar
                        </button>
                    </div>
                @endif
            @endif
        </div>

        <div class="card-footer">
            <a
                href="{{ route('personal.show', ['personal' => $personalId]) }}"
                class="btn btn-default"
            >
                <i class="fas fa-arrow-left"></i>
                Volver a la ficha nueva
            </a>
        </div>
    </div>
</div>