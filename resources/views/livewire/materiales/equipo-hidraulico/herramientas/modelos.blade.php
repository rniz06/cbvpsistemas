<div>
    <!-- Formulario -->
    @canany([
        'Equipo Hidraulico Herramientas Modelos Crear',
        'Equipo Hidraulico Herramientas Modelos Editar',
        'Equipo Hidraulico Herramientas Modelos
        Eliminar',
        ])
        <x-card-form>
            <x-card-input label="Modelo" placeholder="Modelo..." campo="modelo" :disabled="in_array($modo, ['inicio', 'seleccionado'])" />


            <x-slot name="buttons">
                @can('Equipo Hidraulico Herramientas Modelos Crear')
                    <x-button type="button" icon="fas fa-plus" color="success" click="agregar" :disabled="in_array($modo, ['agregar', 'modificar', 'seleccionado'])">Agregar</x-button>
                @endcan

                @can('Equipo Hidraulico Herramientas Modelos Editar')
                    <x-button type="button" icon="fas fa-edit" color="primary" click="editar"
                        :disabled="in_array($modo, ['inicio', 'modificar', 'agregar'])">Modificar</x-button>
                @endcan

                @can('Equipo Hidraulico Herramientas Modelos Eliminar')
                    <x-button type="button" icon="fas fa-trash" color="danger" id="btn-eliminar"
                        :disabled="in_array($modo, ['agregar', 'modificar', 'inicio'])">Eliminar</x-button>
                @endcan

                @canany(['Equipo Hidraulico Herramientas Modelos Crear', 'Equipo Hidraulico Herramientas Modelos Editar'])
                    <x-button type="submit" color="default" :disabled="in_array($modo, ['inicio', 'seleccionado'])" id="btn-grabar">Grabar</x-button>
                @endcanany

                <x-button type="button" icon="fas fa-window-close" color="warning" click="cancelar"
                    :disabled="in_array($modo, ['inicio'])">Cancelar</x-button>
            </x-slot>
        </x-card-form>
    @endcanany
    
    <!-- Tabla -->
    <x-tabla titulo="Parametros - Equipo Hidraulico - Herramientas - Modelos de {{ $marca->marca ?? 'N/A' }}">
        <x-slot name="cabeceras">
            <th>Modelo:</th>
        </x-slot>

        @foreach ($modelos as $modelo)
            <tr wire:click="seleccionado({{ $modelo->idhidraulico_herr_modelo }})"
                wire:key="{{ $modelo->idhidraulico_herr_modelo }}">
                <td>{{ $modelo->modelo ?? 'N/A' }}</td>
            </tr>
        @endforeach
        <x-slot name="paginacion">
            {{ $modelos->links() }}
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
