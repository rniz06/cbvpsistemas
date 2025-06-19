<div>
    <h4>Ficha de Compañia</h4>
    <div class="row">
        <x-callout.ficha titulo="Compañía">{{ $compania->compania ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Ciudad">{{ $compania->ciudad ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Departamento">{{ $compania->departamento ?? 'N/A' }}</x-callout.ficha>
    </div>

    @if ($formVisible)
        {{-- Formulario Agregar Equipo Hidraulico --}}
        <form wire:submit="guardar">
    <x-adminlte-card title="Agregar Equipo Hidraulico" icon="fas fa-plus" theme-mode="outline"
        header-class="bg-success">

        <div class="row align-items-end">  <!-- Cambiado a align-items-end -->
            {{-- CAMPO MARCA --}}
            <div class="col-md-2">
                <x-adminlte-select name="marca_id" label="Marca:" wire:model.live="marca_id">
                    <option>Seleccionar...</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca->id_hidraulico_marca }}">{{ $marca->marca ?? 'N/A' }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            {{-- CAMPO MODELO --}}
            <div class="col-md-2">
                <x-adminlte-select name="modelo_id" label="Modelo:" wire:model.live="modelo_id">
                    <option>Seleccionar...</option>
                    @foreach ($modelos as $modelo)
                        <option value="{{ $modelo->id_hidraulico_modelo }}">{{ $modelo->modelo ?? 'N/A' }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>

            {{-- CAMPO MOTOR --}}
            <div class="col-md-2">
                <x-adminlte-select name="motor_id" label="Motor:" wire:model.live="motor_id">
                    <option>Seleccionar...</option>
                    @foreach ($motores as $motor)
                        <option value="{{ $motor->id_hidraulico_motor }}">{{ $motor->motor ?? 'N/A' }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            {{-- CAMPO ANHO --}}
            <div class="col-md-2">
                <x-adminlte-input name="anho" label="Año de Fábrica:" wire:model.live="anho"
                    placeholder="Si no Cuenta Ingresar: 0000" />
            </div>

            {{-- BOTON DE GUARDADO --}}
            <div class="col-md-2">
                <x-adminlte-button label="Guardar" icon="fas fa-save" type="submit" theme="success"
                    class="mb-3" />  <!-- Agregada clase mb-3 -->
            </div>
        </div>

    </x-adminlte-card>
</form>
    @endif

    {{-- Tabla de Hidraulicos --}}
    <div class="col-md-12">
        <x-table.table titulo="Equipos Hidraulicos" ocultarBuscador personalizarPaginacion="paginadoHidraulicos">


            @canany(['Equipos Hidraulicos Crear'])
                <x-slot name="headerBotones">
                    <button class="btn btn-outline-success btn-sm" wire:click="$toggle('formVisible')">
                        <i class="fas fa-{{ $formVisible ? 'minus' : 'plus' }}"></i>
                        {{ $formVisible ? 'Cancelar' : 'Agregar Equipo Hidraulico' }}
                    </button>
                </x-slot>
            @endcanany

            <x-slot name="cabeceras">
                <th>Marca:</th>
                <th>Estado:</th>
            </x-slot>

            @foreach ($hidraulicos as $hidraulico)
                <tr>
                    <td>{{ $hidraulico->marca ?? 'N/A' }}</td>
                    <td><span
                            class="badge badge-{{ $hidraulico->operatividad == 'OPERATIVO' ? 'success' : 'danger' }}">{{ $hidraulico->operatividad }}</span>
                    </td>
                    @can('Equipos Hidraulicos Ver')
                        <td><a href="{{ route('materiales.hidraulicos.show', $hidraulico->id_hidraulico) }}"
                                class="btn btn-sm btn-{{ $hidraulico->operatividad == 'OPERATIVO' ? 'success' : 'danger' }} btn-block">Ver
                                Ficha</a></td>
                    @endcan
                </tr>
            @endforeach
            <x-slot name="paginacion">
                {{ $hidraulicos->links() }}
            </x-slot>
        </x-table.table>
    </div>

</div>
