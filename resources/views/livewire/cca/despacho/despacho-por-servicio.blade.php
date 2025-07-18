<div>
    <h4>Datos del servicio</h4>

    {{-- Formulario --}}
    <x-adminlte-card theme="success" theme-mode="outline">
        <form class="col-md-12 row" wire:submit="grabar">
            {{-- Servicio --}}
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
                <x-adminlte-select name="ciudad_id" label="ciudad:" wire:model.blur="ciudad_id">
                    <option>-- Seleccionar --</option>
                    @forelse ($ciudades as $ciudad)
                        <option value="{{ $ciudad->id_ciudad ?? 'null' }}">
                            {{ $ciudad->ciudad ?? 'S/D' }}</option>
                    @empty
                        <option>Sin datos...</option>
                    @endforelse
                </x-adminlte-select>
            </div>

            {{-- Informaciones --}}
            <x-adminlte-input name="calle_referencia" label="Calles/Referencias:" placeholder="Calles/Referencias..."
                fgroup-class="col-md-9" oninput="this.value = this.value.toUpperCase()"
                wire:model.blur="calle_referencia" />            

            {{-- Botones --}}
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save" />
            </div>
        </form>
    </x-adminlte-card>
</div>
