<div>
    {{-- Formulario --}}
    @canany(['Cargos Crear', 'Cargos Editar', 'Cargos Eliminar'])
        <x-adminlte-card theme="success" theme-mode="outline">
            <form class="col-md-12 row" wire:submit="grabar">

                {{-- Cargo --}}
                <x-adminlte-input name="cargo" label="Cargo:" placeholder="Cargo..." fgroup-class="col-md-3"
                    oninput="this.value = this.value.toUpperCase()" wire:model.blur="cargo" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />

                {{-- Tipo Codigo --}}
                <div class="col-md-3">
                    <x-adminlte-select name="tipo_codigo" label="Tipo De Codigo:" wire:model.blur="tipo_codigo"
                        :disabled="in_array($modo, ['inicio', 'seleccionado'])">
                        <option>-- Seleccionar --</option>
                        @forelse (App\Enums\Personal\Cargo\TipoCodigo::cases() as $tipo_codigo)
                            <option value="{{ $tipo_codigo->name ?? 'S/D' }}">
                                {{ $tipo_codigo->name ?? 'S/D' }}</option>
                        @empty
                            <option>Sin datos...</option>
                        @endforelse
                    </x-adminlte-select>
                </div>

                {{-- Codigo Base --}}
                <x-adminlte-input name="codigo_base" label="Cod. Comisionamiento(* En caso de Aut. Electas):"
                    placeholder="Cod. Comisionamiento(* En caso de Aut. Electas)..." fgroup-class="col-md-3"
                    oninput="this.value = this.value.toUpperCase()" wire:model.blur="codigo_base" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />

                {{-- Rango --}}
                <div class="col-md-3">
                    <x-adminlte-select name="rango_id" label="Rango:" wire:model.blur="rango_id" :disabled="in_array($modo, ['inicio', 'seleccionado'])">
                        <option>-- Seleccionar --</option>
                        @foreach ($rangos as $rango)
                            <option value="{{ $rango->id_rango ?? 'S/D' }}">{{ $rango->rango ?? 'S/D' }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- Botones --}}
                <div class="card-footer">
                    @can('Cargos Crear')
                        <x-adminlte-button type="button" label="Agregar" theme="success" icon="fas fa-lg fa-plus"
                            wire:click="agregar" :disabled="in_array($modo, ['agregar', 'modificar', 'seleccionado'])" />
                    @endcan
                    @can('Cargos Editar')
                        <x-adminlte-button type="button" label="Modificar" theme="warning" icon="fas fa-lg fa-edit"
                            wire:click="editar" :disabled="in_array($modo, ['inicio', 'modificar', 'agregar'])" />
                    @endcan
                    @can('Cargos Eliminar')
                        <x-adminlte-button type="button" label="Eliminar" theme="danger" icon="fas fa-lg fa-trash"
                            id="btn-eliminar" :disabled="in_array($modo, ['agregar', 'modificar', 'inicio'])" />
                    @endcan
                    @canany(['Cargos Crear', 'Cargos Editar'])
                        <x-adminlte-button type="button" label="Grabar" theme="default" icon="fas fa-lg fa-save"
                            id="btn-grabar" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />
                    @endcanany


                    <x-adminlte-button type="button" label="Cancelar" theme="secondary" icon="fas fa-lg fa-window-close"
                        wire:click="cancelar" :disabled="in_array($modo, ['inicio'])" />
                </div>
            </form>
        </x-adminlte-card>
    @endcanany
</div>

@push('scripts')
    {{-- Script para boton guardar --}}
    <script>
        const btnGuardar = document.getElementById('btn-grabar');
        if (btnGuardar) {
            btnGuardar.addEventListener('click', function() {
                // Obtener el modo actual directamente de Livewire                 
                const modoActual = @this.get('modo');

                let titulo = modoActual === 'modificar' ? 'MODIFICAR' : 'AGREGAR';
                let mensaje = modoActual === 'modificar' ? '¿DESEAS ACTUALIZAR EL REGISTRO?' :
                    '¿DESEAS GRABAR EL NUEVO REGISTRO?';
                let respuesta = modoActual === 'modificar' ? 'Registro Actualizado Con Éxito' :
                    'Registro Creado Con Éxito';

                Swal.fire({
                    title: titulo,
                    text: mensaje,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#458E49",
                    confirmButtonText: "SI",
                    cancelButtonText: "NO",
                    closeOnConfirm: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.grabar();
                        Swal.fire({
                            title: "Respuesta",
                            text: respuesta,
                            icon: "success"
                        });
                    }
                });
            });
        }
    </script>

    {{-- Script para boton eliminar --}}
    <script>
        const btnEliminar = document.getElementById('btn-eliminar');
        if (btnEliminar) {
            btnEliminar.addEventListener('click', function() {
                Swal.fire({
                    title: "ELIMINAR",
                    text: "¿DESEAS ELIMINAR EL REGISTRO SELECCIONADO?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#458E49",
                    confirmButtonText: "SI",
                    cancelButtonText: "NO",
                    closeOnConfirm: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.eliminar();
                        Swal.fire({
                            title: "Respuesta",
                            text: "Registro Eliminado Con Exito",
                            icon: "success"
                        });
                    }
                });
            });
        }
    </script>
    <!-- Script para select2 -->
    <script>
        $(document).ready(function() {
            $('#ciudad').select2({
                placeholder: 'Seleccionar...',
                language: "es",
            });
        });
    </script>
@endpush
