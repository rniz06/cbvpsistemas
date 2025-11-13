<div>

    <form wire:submit="guardar">
        <x-adminlte-callout theme="success" class="col-md-12 row">
            {{-- Nombre Completo --}}
            <x-adminlte-input name="nombrecompleto" label="Nombre Completo:" placeholder="Nombre Completo...."
                fgroup-class="col-md-3" wire:model.blur="nombrecompleto" />

            {{-- Categoria --}}
            <x-adminlte-select name="categoria_id" label="Categoria:" fgroup-class="col-md-3"
                wire:model.blur="categoria_id">
                <option>-- Seleccionar --</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->idpersonal_categorias }}">{{ $categoria->categoria ?? 'N/A' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Codigo --}}
            <x-adminlte-input type="number" name="codigo" label="Codigo:" placeholder="Codigo...."
                fgroup-class="col-md-3" wire:model.blur="codigo" />

            {{-- Compania --}}
            <x-adminlte-select name="compania_id" label="Compañia:" fgroup-class="col-md-3"
                wire:model.blur="compania_id">
                <option>-- Seleccionar --</option>
                @foreach ($companias as $compania)
                    <option value="{{ $compania->id_compania }}">
                        {{ $compania->compania ?? 'N/A' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Tipo Documento --}}
            <x-adminlte-select name="tipo_documento_id" label="Tipo De Documento:" fgroup-class="col-md-3"
                wire:model.blur="tipo_documento_id">
                @foreach ($tiposDocumentos as $tipoDocumento)
                    <option value="{{ $tipoDocumento->id_tipo_documento }}">
                        {{ $tipoDocumento->tipo_documento ?? 'N/A' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Documento --}}
            <x-adminlte-input type="number" name="documento" label="Documento:" placeholder="Documento...."
                fgroup-class="col-md-3" wire:model.blur="documento" />

            {{-- Fecha de Juramento --}}
            <x-adminlte-input type="date" name="fecha_de_juramento" label="Fecha de Juramento:"
                fgroup-class="col-md-3" wire:model.blur="fecha_de_juramento" />

            {{-- Fecha de Nacimiento --}}
            <x-adminlte-input type="date" name="fecha_nacimiento" label="Fecha de Nacimiento:"
                fgroup-class="col-md-3" wire:model.blur="fecha_nacimiento" />

            {{-- Estado --}}
            <x-adminlte-select name="estado_id" label="Estado:" fgroup-class="col-md-3" wire:model.blur="estado_id">
                <option>-- Seleccionar --</option>
                @foreach ($estados as $estado)
                    <option value="{{ $estado->idpersonal_estados }}">{{ $estado->estado ?? 'N/A' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Sexo --}}
            <x-adminlte-select name="sexo_id" label="Sexo:" fgroup-class="col-md-3" wire:model.blur="sexo_id">
                <option>-- Seleccionar --</option>
                @foreach ($sexos as $sexo)
                    <option value="{{ $sexo->idpersonal_sexo }}">{{ $sexo->sexo ?? 'N/A' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Nacionalidad --}}
            <x-adminlte-select name="nacionalidad_id" label="Nacionalidad:" fgroup-class="col-md-3"
                wire:model.blur="nacionalidad_id">
                <option>-- Seleccionar --</option>
                @foreach ($paises as $pais)
                    <option value="{{ $pais->idpaises }}">{{ $pais->pais ?? 'N/A' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Grupo Sanguineo --}}
            <x-adminlte-select name="grupo_sanguineo_id" label="Grupo Sanguineo:" fgroup-class="col-md-3"
                wire:model.blur="grupo_sanguineo_id">
                <option>-- Seleccionar --</option>
                @foreach ($gruposSanguineos as $grupoSanguineo)
                    <option value="{{ $grupoSanguineo->idpersonal_grupo_sanguineo }}">
                        {{ $grupoSanguineo->grupo_sanguineo ?? 'N/A' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Estado actualizar --}}
            <x-adminlte-select name="estado_actualizar_id" label="Ficha Completamento Actualizada?"
                fgroup-class="col-md-3" wire:model.blur="estado_actualizar_id">
                @foreach ($estadosActualizar as $estadoActualizar)
                    <option value="{{ $estadoActualizar->idpersonal_estado_actualizar }}">
                        {{ $estadoActualizar->estado ?? 'N/A' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Botón de Volver --}}
            <div class="form-group col-md-3 d-flex align-items-end">
                <a href="{{ route('personal.index') }}" class="w-100 btn btn-secondary text-white"><i
                        class="fas fa-arrow-left mr-1"></i> Volver</a>
            </div>

            {{-- Botón de Guardar --}}
            <div class="form-group col-md-3 d-flex align-items-end">
                <x-adminlte-button type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save"
                    class="w-100" />
            </div>

            {{-- Rellenar espacio faltante --}}
            <div class="col-md-6"></div>


        </x-adminlte-callout>
    </form>
</div>
