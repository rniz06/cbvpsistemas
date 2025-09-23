<div>
    {{-- Formulario --}}
    <x-adminlte-callout theme="success">
        <form class="col-md-12 row" wire:submit="guardar">

            <div class="col-md-12">
                <h5>1. Seleccionar el Personal Bombero</h5>
            </div>
            {{-- Categoria --}}
            <x-adminlte-select label="Categoria" name="categoria_id" wire:model.blur="categoria_id" fgroup-class="col-md-4">
                <option value="">-- SELECCIONAR --</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->idpersonal_categorias }}">{{ $categoria->categoria ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Codigo --}}
            <x-adminlte-input type="number" name="codigo" label="Codigo:" placeholder="8699" fgroup-class="col-md-4"
                wire:model.blur="codigo" />

            {{-- Info Personal --}}
            <div class="form-group col-md-4">
                <label>Información Del Personal:</label>
                <input type="text" class="form-control" value="{{ $info_personal_label }}" readonly />
            </div>

            {{-- Linea --}}
            <div class="col-md-12">
                <hr />
                <h5>2. Datos adicionales</h5>
            </div>

            {{-- Fecha Curso --}}
            <x-adminlte-input type="date" name="fecha_curso" label="Fecha de realización del Curso:"
                fgroup-class="col-md-3" wire:model.blur="fecha_curso" />

            {{-- Ciudad Curso --}}
            <x-adminlte-select label="Ciudad de realización" name="ciudad_curso_id" wire:model.blur="ciudad_curso_id"
                fgroup-class="col-md-3">
                <option value="">-- SELECCIONAR --</option>
                @foreach ($ciudades as $ciudad)
                    <option value="{{ $ciudad->id_ciudad }}">{{ $ciudad->ciudad ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Tipo Vehiculo --}}
            <x-adminlte-select label="Tipo de vehiculo" name="tipo_vehiculo_id" wire:model.blur="tipo_vehiculo_id"
                fgroup-class="col-md-3">
                <option value="">-- SELECCIONAR --</option>
                @foreach ($tiposVehiculos as $tipoVehiculo)
                    <option value="{{ $tipoVehiculo->idconductor_tipo_vehiculo }}">{{ $tipoVehiculo->tipo ?? 'S/D' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Numero Licencia --}}
            <x-adminlte-input type="number" name="numero_licencia" label="Número de Licencia:" placeholder="4791256"
                fgroup-class="col-md-3" wire:model.blur="numero_licencia" />

            {{-- Ciudad Licencia --}}
            <x-adminlte-select label="Municipio" name="ciudad_licencia_id" wire:model.blur="ciudad_licencia_id"
                fgroup-class="col-md-3">
                <option value="">-- SELECCIONAR --</option>
                @foreach ($ciudades as $ciudad)
                    <option value="{{ $ciudad->id_ciudad }}">{{ $ciudad->ciudad ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Clase Licencia --}}
            <x-adminlte-select label="Clase Licencia" name="clase_licencia_id" wire:model.blur="clase_licencia_id"
                fgroup-class="col-md-3">
                <option value="">-- SELECCIONAR --</option>
                @foreach ($licencias as $licencia)
                    <option value="{{ $licencia->idconductor_clase_licencia }}">{{ $licencia->clase ?? 'S/D' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Licencia Vencimiento --}}
            <x-adminlte-input type="date" name="licencia_vencimiento" label="Fecha de Vencimiento de la Licencia:"
                fgroup-class="col-md-3" wire:model.blur="licencia_vencimiento" />

            {{-- Linea --}}
            <div class="col-md-12">
                <hr />
                <h5>3. Datos de la Resolución</h5>
            </div>

            {{-- Origen --}}
            <x-adminlte-select label="Origen" name="origen_id" wire:model.blur="origen_id" fgroup-class="col-md-4">
                <option value="">-- SELECCIONAR --</option>
                @foreach ($origenes as $origen)
                    <option value="{{ $origen->id }}">{{ $origen->origen ?? 'S/D' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Anho --}}
            <x-adminlte-select label="Año de la Resolución" name="anho_id" wire:model.blur="anho_id"
                fgroup-class="col-md-4">
                <option value="">-- SELECCIONAR --</option>
                @foreach ($anhos as $anho)
                    <option value="{{ $anho }}">{{ $anho }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Resoluciones --}}
            <x-adminlte-select label="Resolución" name="resolucion_id" wire:model.blur="resolucion_id"
                fgroup-class="col-md-4">
                <option value="">-- SELECCIONAR --</option>
                @foreach ($resoluciones as $resolucion)
                    <option value="{{ $resolucion->id }}">{{ $resolucion->n_resolucion ?? 'S/D' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Info Resolucion --}}
            <div class="form-group col-md-12">
                <label>Información De la Resolución:</label>
                <input type="text" class="form-control" value="{{ $info_resolucion_label }}" readonly />
            </div>

            {{-- Botón de Volver --}}
            <div class="form-group col-md-3 d-flex align-items-end">
                <a href="{{ route('materiales.conductores.index') }}"
                    class="btn btn-block btn-secondary text-decoration-none text-white"><i
                        class="fas fa-arrow-left"></i>Volver</a>
            </div>

            {{-- Botón de Guardar --}}
            <div class="form-group col-md-3 d-flex align-items-end">
                <x-adminlte-button type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save"
                    class="w-100" />
            </div>
        </form>
    </x-adminlte-callout>
</div>
