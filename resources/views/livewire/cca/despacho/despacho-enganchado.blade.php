<div>

    <x-adminlte-card theme="success" theme-mode="outline"
        title="Ficha de despacho - Compañía {{ $servicio->compania->compania ?? 'S/D' }} Móvil {{ $servicio->movil->acronimo->tipo ?? 'S/D' }}-{{ $servicio->movil->movil ?? 'S/D' }}">

        <form class="col-md-12 row" wire:submit="grabar">
            <div class="col-md-2">
                <x-adminlte-select name="servicio_id" label="Servicio:" wire:model.live="servicio_id">
                    <option>Seleccionar...</option>
                    @forelse ($servicios as $servicio)
                        <option value="{{ $servicio->id_servicio ?? 'null' }}">{{ $servicio->servicio ?? 'S/D' }}
                        </option>
                    @empty
                        <option>Sin datos...</option>
                    @endforelse
                </x-adminlte-select>
            </div>

            {{-- Clasificacion --}}
            <div class="col-md-2">
                <x-adminlte-select name="clasificacion_id" label="Clasificación:" wire:model.live="clasificacion_id">
                    <option>-- Seleccionar --</option>
                    @forelse ($clasificaciones as $clasificacion)
                        <option value="{{ $clasificacion->id_servicio_clasificacion ?? 'null' }}">
                            {{ $clasificacion->clasificacion ?? 'S/D' }}</option>
                    @empty
                    @endforelse
                </x-adminlte-select>
            </div>

            {{-- Informaciones --}}
            <x-adminlte-input name="informacion_servicio" label="Informaciones:" placeholder="Informaciones..."
                fgroup-class="col-md-8" oninput="this.value = this.value.toUpperCase()"
                wire:model.blur="informacion_servicio" />

            {{-- Ciudad --}}
            <div class="col-md-3">
                <div class="form-group">
                    <label>Ciudad del Servicio:</label>
                    <div wire:ignore>
                        <select class="form-control @error('ciudad_id') is-invalid @enderror" id="ciudad_id"
                            name="ciudad_id" wire:model.blur="ciudad_id">
                            <option value="">-- Seleccionar --</option>
                            @foreach ($ciudades as $ciudad)
                                <option value="{{ $ciudad->id_ciudad ?? 'null' }}">
                                    {{ $ciudad->ciudad ?? 'S/D' }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('ciudad_id')
                        <div class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </div>

            {{-- Calles/Referencias --}}
            <x-adminlte-input name="calle_referencia" label="Calles/Referencias:" placeholder="Calles/Referencias..."
                fgroup-class="col-md-9" oninput="this.value = this.value.toUpperCase()"
                wire:model.blur="calle_referencia" />

            {{-- GUARDAR --}}
            <x-adminlte-button type=submit theme="outline-success" label="Guardar" icon="fas fa-save" />

        </form>
    </x-adminlte-card>

</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/slimselect.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/slimselect.js') }}"></script>

    <script>
        new SlimSelect({
            select: '#ciudad_id'
        })
    </script>
@endpush