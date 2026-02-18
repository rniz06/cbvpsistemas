<div>
    {{-- Datos del servicio --}}
    <h4>Datos del servicio</h4>
    <x-adminlte-card theme="success" theme-mode="outline">
        <div class="col-md-12 row">
            {{-- Servicio --}}
            <x-adminlte-input name="" label="Servicio:" value="{{ $servicio->servicio ?? 'S/D' }}"
                fgroup-class="col-md-2" disabled />

            {{-- Clasificacion --}}
            <x-adminlte-input name="" label="Clasificacion:" value="{{ $servicio->clasificacion ?? 'S/D' }}"
                fgroup-class="col-md-2" disabled />

            {{-- Informaciones --}}
            <x-adminlte-input name="" label="Informaciones:"
                value="{{ $servicio->informacion_servicio ?? 'S/D' }}" fgroup-class="col-md-8" disabled />

            {{-- Ciudad --}}
            <x-adminlte-input name="" label="Ciudad:" value="{{ $servicio->ciudad ?? 'S/D' }}"
                fgroup-class="col-md-3" disabled />

            {{-- Calles/Referencias --}}
            <x-adminlte-input name="" label="Calles/Referencias:"
                value="{{ $servicio->calle_referencia ?? 'S/D' }}" fgroup-class="col-md-9" disabled />
        </div>
    </x-adminlte-card>

    {{-- Formulario --}}
    <h4>Agregar Compañia</h4>
    <x-adminlte-card theme="success" theme-mode="outline">
        <form wire:submit="grabar" class="col-md-12 row">
            {{-- Compania --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label>Compañia:</label>
                    <div wire:ignore>
                        <select class="form-control @error('compania_id') is-invalid @enderror" id="compania_id"
                            name="compania_id" wire:model.blur="compania_id">
                            <option value="">-- Seleccionar --</option>
                            @foreach ($companias as $compania)
                                <option value="{{ $compania->id_compania }}">
                                    {{ $compania->compania ?? 'S/D' }} -
                                    {{ $compania->departamento ?? 'S/D' }} -
                                    {{ $compania->ciudad ?? 'S/D' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('compania_id')
                        <div class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </div>

            {{-- <div class="col-md-4" wire:ignore>
                <div class="form-group">
                    <label>Compañia:</label>
                    <select class="form-control" id="compania_id" name="compania_id" wire:model.blur="compania_id">
                        <option>-- Seleccionar --</option>
                        @foreach ($companias as $compania)
                            <option value="{{ $compania->id_compania ?? 'null' }}">{{ $compania->compania ?? 'S/D' }} -
                            {{ $compania->departamento ?? 'S/D' }} - {{ $compania->ciudad ?? 'S/D' }}
                        </option>
                        @endforeach
                    </select>
                    @error('compania_id')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
            </div> --}}

            {{-- Botones --}}
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save" />
            </div>
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
            select: '#compania_id'
        })
    </script>
@endpush
