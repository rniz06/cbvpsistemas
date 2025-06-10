<div>
    <!-- Formulario -->

    <x-card-form>
        <x-card-input label="Acrónimo" placeholder="Acrónimo..." campo="tipo" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />

        <x-card-input label="Descripción" placeholder="Descripción..." campo="descripcion" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />


        <x-slot name="buttons">
            <x-button type="button" icon="fas fa-plus" color="success" click="agregar"
                :disabled="in_array($modo, ['agregar', 'modificar', 'seleccionado'])">Agregar</x-button>

            <x-button type="button" icon="fas fa-edit" color="primary" click="editar"
                :disabled="in_array($modo, ['inicio', 'modificar', 'agregar'])">Modificar</x-button>

            <x-button type="submit" color="default" :disabled="in_array($modo, ['inicio', 'seleccionado'])" id="btn-grabar">Grabar</x-button>

            <x-button type="button" icon="fas fa-window-close" color="warning" click="cancelar"
                :disabled="in_array($modo, ['inicio'])">Cancelar</x-button>
        </x-slot>
    </x-card-form>

    <!-- Tabla -->
    <x-tabla titulo="Parametros - Acrónimos">
        <x-slot name="cabeceras">
            <th>Acrónimo:</th>
            <th>Descripción:</th>
            <th>Estado:</th>
            <th>Acciones:</th>
        </x-slot>

        @foreach ($acronimos as $acronimo)
            <tr wire:click="seleccionado({{ $acronimo->id_movil_tipo }})" wire:key="{{ $acronimo->id_movil_tipo }}">
                <td>{{ $acronimo->tipo ?? 'N/A' }}</td>
                <td>{{ $acronimo->descripcion ?? 'N/A' }}</td>
                <td>{{ $acronimo->activo ? 'Activo' : 'Inactivo' }}</td>
                <td>
                    <button class="btn btn-sm" style="border:none;background:transparent;"
                        wire:click="cambiarEstado({{ $acronimo->id_movil_tipo }}, true)"
                        onclick="confirm('¿Seguro que desea cambiar el estado a ACTIVO?') || event.stopImmediatePropagation()">
                        <img width="30px" src="{{ asset('img/ok.webp') }}">
                    </button>

                    <button class="btn btn-sm" style="border:none;background:transparent;"
                        wire:click="cambiarEstado({{ $acronimo->id_movil_tipo }}, false)"
                        onclick="confirm('¿Seguro que desea cambiar el estado a INACTIVO?') || event.stopImmediatePropagation()">
                        <img width="30px" src="{{ asset('img/wrong.webp') }}">
                    </button>
                </td>

            </tr>
        @endforeach
        <x-slot name="paginacion">
            {{ $acronimos->links() }}
        </x-slot>
    </x-tabla>

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
@endpush

@push('css')
@endpush
