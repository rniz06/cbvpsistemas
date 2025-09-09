<div>
    {{-- Formulario --}}
    <x-adminlte-card theme="success" theme-mode="outline">
        <form class="col-md-12 row" wire:submit="grabar">
            {{-- Dirección --}}
            <x-adminlte-input name="direccion" label="Dirección:" placeholder="Dirección..." fgroup-class="col-md-6"
                oninput="this.value = this.value.toUpperCase()" wire:model.blur="direccion" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />

            {{-- Compañia --}}
            <div class="col-md-6">
                <x-adminlte-select name="compania_id" label="Compañia:" wire:model.blur="compania_id" :disabled="in_array($modo, ['inicio', 'seleccionado'])">
                    <option>-- Seleccionar --</option>
                    @foreach ($companias as $compania)
                        <option value="{{ $compania->id_compania ?? 'S/D' }}">{{ $compania->compania ?? 'S/D' }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>

            {{-- Botones --}}
            <div class="card-footer">
                <x-adminlte-button type="button" label="Agregar" theme="success" icon="fas fa-lg fa-plus"
                    wire:click="agregar" :disabled="in_array($modo, ['agregar', 'modificar', 'seleccionado'])" />

                <x-adminlte-button type="button" label="Modificar" theme="warning" icon="fas fa-lg fa-edit"
                    wire:click="editar" :disabled="in_array($modo, ['inicio', 'modificar', 'agregar'])" />

                <x-adminlte-button type="button" label="Eliminar" theme="danger" icon="fas fa-lg fa-trash"
                    id="btn-eliminar" :disabled="in_array($modo, ['agregar', 'modificar', 'inicio'])" />

                <x-adminlte-button type="button" label="Grabar" theme="default" icon="fas fa-lg fa-save"
                    id="btn-grabar" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />

                <x-adminlte-button type="button" label="Cancelar" theme="secondary" icon="fas fa-lg fa-window-close"
                    wire:click="cancelar" :disabled="in_array($modo, ['inicio'])" />
            </div>
        </form>
    </x-adminlte-card>
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