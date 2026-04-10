<div class="row">
    {{-- Do your work, then step back. --}}
    <h4>Ficha de Compañia: {{ $compania->compania ?? 'S/D' }}</h4>

    @if ($ver_form_alta)
        <br>
        <div class="col-md-12">
            @livewire('materiales.menor.menor.create', ['companiaId' => $compania->id_compania])
        </div>
    @endif

    {{-- ITEMS --}}
    <div class="col-md-12">
        <x-table.tabla titulo="Material Menor" dropdown_direccion="dropleft" paginado="paginado">

            @can('Material Menor Crear')
                <x-slot name="acciones">
                    <x-adminlte-button :label="$ver_form_alta ? 'Cerrar Formulario' : 'Añadir Item'" class="btn-sm dropdown-item" :icon="$ver_form_alta ? 'fas fa-times' : 'fas fa-plus'"
                        wire:click="$toggle('ver_form_alta')" />
                </x-slot>
            @endcan

            <x-slot name="encabezados">
                {{-- NUMERO EN LA FILA --}}
                <th style="width: 10px">N°</th>

                {{-- NOMBRE --}}
                <th>Nombre</th>

                {{-- MARCA --}}
                <th>Marca</th>

                {{-- COMPAÑIA --}}
                <th>Estado</th>

                <th></th>

            </x-slot>

            @forelse ($items as $index => $item)
                <tr>
                    <td>{{ $loop->iteration + $items->firstItem() - 1 }}</td>
                    <td>{{ $item->componente->nombre ?? 'S/D' }}</td>
                    <td>{{ $item->marca->nombre ?? 'S/D' }}</td>
                    <td>
                        @if ($item->estado->operatividad === 'OPERATIVO')
                            <span class="badge badge-success">OPERATIVO</span>
                        @elseif ($item->estado->operatividad === 'INOPERATIVO')
                            <span class="badge badge-danger">INOPERATIVO</span>
                        @else
                            <span class="badge badge-secondary">S/D</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('materiales.menor.ver-ficha', $item->id_menor_item) }}"
                            class="btn btn-sm w-100 
                            @if ($item->estado->operatividad === 'OPERATIVO') btn-outline-success
                            @elseif ($item->estado->operatividad === 'INOPERATIVO')
                                btn-outline-danger
                            @else
                                btn-outline-secondary @endif">
                            <i class="fas fa-eye mr-1"></i> Ver Ficha
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                    </td>
                </tr>
            @endforelse

            <x-slot name="paginacion">
                {{ $items->links() }}
            </x-slot>
        </x-table.tabla>
    </div>
</div>


@push('styles')
    <link rel="stylesheet" href="{{ asset('css/slimselect.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/slimselect.js') }}"></script>

    <script>
        // RECIBIR EVENTO DEL COMPONENTE HIJO Y ACTIVAR LOS SELECTS
        Livewire.on('ver-form-alta', () => {
            // alert('Funciona');
            new SlimSelect({
                select: '#componente_id'
            })

            new SlimSelect({
                select: '#marca_id'
            })
        });
    </script>
@endpush
