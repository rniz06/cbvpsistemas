<div>
    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5><i class="fas fa-check-circle mr-2" style="color: #28a745"></i>{{ $message }}</h5>
        </div>
    @endif

    <!-- Tabla -->
    <x-tabla titulo="Listado de Direcciones" excel pdf>
        <x-slot name="cabeceras">
            <th>
                <div>
                    <x-adminlte-input name="buscarDireccion" label="Dirección:" placeholder="Dirección..."
                        fgroup-class="col-md-12" wire:model.live.debounce.250ms="buscarDireccion"
                        oninput="this.value = this.value.toUpperCase()" />
                </div>
            </th>
            <th>
                <div>
                    <x-adminlte-input name="buscarCompania" label="Depende De:" placeholder="Depende De..."
                        fgroup-class="col-md-12" wire:model.live.debounce.250ms="buscarCompania"
                        oninput="this.value = this.value.toUpperCase()" />
                </div>
            </th>
        </x-slot>

        @forelse ($direcciones as $direccion)
            <tr wire:click="seleccionado({{ $direccion->id_direccion }})" wire:key="{{ $direccion->id_direccion }}">
                <td>{{ $direccion->direccion ?? 'S/D' }}</td>
                <td>{{ $direccion->compania ?? 'S/D' }}</td>
            </tr>
        @empty
            <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
        @endforelse

        <x-slot name="paginacion">
            {{ $direcciones->links() }}
        </x-slot>
    </x-tabla>

</div>
