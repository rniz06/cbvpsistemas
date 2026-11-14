
<div>
    <x-adminlte-card
        theme="light"
        title="Crear período de asistencia"
        icon="fas fa-calendar-alt"
        header-class="text-muted text-sm"
    >
        @if (session()->has('success'))
            <div class="alert alert-success mx-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="alert alert-info mx-3">
            Seleccioná el año y el mes. El sistema propondrá la fecha
            límite de presentación, que podrás modificar antes de guardar.
        </div>

        <form wire:submit="guardar" class="row p-3">

            <div class="form-group col-md-4">
                <label for="anho_id">Año *</label>

                <select
                    id="anho_id"
                    class="form-control @error('anho_id') is-invalid @enderror"
                    wire:model.live="anho_id"
                >
                    <option value="">-- Seleccionar año --</option>

                    @foreach ($anhos as $anho)
                        <option value="{{ $anho->id_anho }}">
                            {{ $anho->anho }}
                        </option>
                    @endforeach
                </select>

                @error('anho_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="mes_id">Mes de asistencia *</label>

                <select
                    id="mes_id"
                    class="form-control @error('mes_id') is-invalid @enderror"
                    wire:model.live="mes_id"
                >
                    <option value="">-- Seleccionar mes --</option>

                    @foreach ($meses as $mes)
                        <option value="{{ $mes->id_mes }}">
                            {{ $mes->mes }}
                        </option>
                    @endforeach
                </select>

                @error('mes_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="fecha_vencimiento">
                    Fecha límite definitiva *
                </label>

                <input
                    type="date"
                    id="fecha_vencimiento"
                    class="form-control @error('fecha_vencimiento') is-invalid @enderror"
                    wire:model="fecha_vencimiento"
                    required
                >

                @error('fecha_vencimiento')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror

                <small class="form-text text-muted">
                    Podés modificar la fecha propuesta antes de guardar.
                </small>
            </div>

            <div class="col-12 d-flex justify-content-between mt-3">
                <a
                    href="{{ route('personal.asistencias.index') }}"
                    class="btn btn-outline-secondary btn-sm"
                >
                    <i class="fas fa-arrow-left mr-1"></i>
                    Volver a asistencias
                </a>

                <button
                    type="submit"
                    class="btn btn-outline-success btn-sm"
                    wire:loading.attr="disabled"
                >
                    <i class="fas fa-save mr-1"></i>
                    Guardar período
                </button>
            </div>
        </form>
    </x-adminlte-card>
</div>
