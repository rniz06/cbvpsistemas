<div>
    {{-- Formulario --}}
    <x-adminlte-card theme="light" title="Agregar Material Menor" icon="fas fa-plus-circle" header-class="text-muted text-sm">
        <form class="col-md-12 row" wire:submit="guardar">

            {{-- COMPONENTE --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Item:</div>
                        </div>
                        <select class="form-control @error('componente_id') is-invalid @enderror"
                            id="componente_id" name="componente_id"
                            wire:model.blur="componente_id">
                            <option value="">-- Seleccionar --</option>
                            @foreach ($this->componentes as $componente)
                                <option value="{{ $componente->id_menor_componente }}">
                                    {{ $componente->nombre ?? 'S/D' }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('componente_id')
                        <div class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </div>

            {{-- MARCA --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Marcas:</div>
                        </div>
                        <select class="form-control @error('marca_id') is-invalid @enderror" id="marca_id"
                            name="marca_id" wire:model.live.blur="marca_id">
                            <option value="">-- Seleccionar --</option>
                            @foreach ($this->marcas as $marca)
                                <option value="{{ $marca->id_menor_marca }}">
                                    {{ $marca->nombre ?? 'S/D' }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('marca_id')
                        <div class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </div>

            {{-- Botón de Volver --}}
            {{-- <div class="form-group col-xl-3 d-flex align-items-end">
                <a href="{{ url()->previous() }}"
                    class="btn btn-block btn-outline-secondary text-decoration-none btn-sm"><i
                        class="fas fa-arrow-left mr-1"></i>Volver</a>
            </div> --}}

            {{-- Botón de Guardar --}}
            <div class="form-group col-xl-3 d-flex align-items-end">
                <x-adminlte-button type="submit" label="Guardar" theme="outline-success" icon="fas fa-lg fa-save"
                    class="w-100 btn-sm" />
            </div>
        </form>
    </x-adminlte-card>
</div>

{{-- @push('styles')
    <link rel="stylesheet" href="{{ asset('css/slimselect.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/slimselect.js') }}"></script>

    <script>
        new SlimSelect({
            select: '#componente_id'
        })

        new SlimSelect({
            select: '#marca_id'
        })
    </script>
@endpush --}}