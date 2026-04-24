<div>

    {{-- <x-adminlte-card theme="secondary" theme-mode="outline"> --}}
    <div class="row col-md-12">
        <div class="col-md-6">
                <x-table.tabla titulo="Material Menor">

                    <x-slot name="encabezados">
                        <th>#</th>
                        <th>Item</th>
                        <th>Cant. Operativos</th>
                        <th>Cant. Inoperativos</th>
                        <th>Compañia</th>
                        <th>Acciones</th>
                    </x-slot>

                    @forelse ($menor as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <th>{{ $item->componente->nombre ?? 'S/D' }}</th>
                            <th>{{ $item->cantidad_operativo ?? 'S/D' }}</th>
                            <th>{{ $item->cantidad_inoperativo ?? 'S/D' }}</th>
                            <th>{{ $item->compania->compania ?? 'S/D' }}</th>
                            <th>
                                <x-adminlte-button label="Ver Movimientos" class="btn-sm w-100" theme="outline-secondary" icon="fas fa-eye" />
                            </th>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                            </td>
                        </tr>
                    @endforelse

                    <x-slot name="paginacion">
                        {{ $menor->links() }}
                    </x-slot>

                </x-table.tabla>
                <br>
                @foreach ($menor as $item)
                    {{ $item ?? 'S/D' }}
                @endforeach
        </div>

        {{-- EQUIPOS FORESTALES --}}
        <div class="col-md-6">
            <x-adminlte-card theme="secondary" theme-mode="outline" title="EQUIPOS FORESTALES" collapsible>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Item</th>
                                <th scope="col">Cant. Operativos</th>
                                <th scope="col">Cant. Inoperativos</th>
                                <th scope="col">Compañia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($forestales as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <th>{{ $item->componente->nombre ?? 'S/D' }}</th>
                                    <th>{{ $item->cantidad_operativo ?? 'S/D' }}</th>
                                    <th>{{ $item->cantidad_inoperativo ?? 'S/D' }}</th>
                                    <th>{{ $item->compania->compania ?? 'S/D' }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
                @foreach ($forestales as $item)
                    {{ $item ?? 'S/D' }}
                @endforeach
            </x-adminlte-card>
        </div>

        <div class="col-md-12">
            {{-- ERAS --}}
            <x-adminlte-card theme="secondary" theme-mode="outline" title="ERAS" collapsible>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Item</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Operativos</th>
                                <th scope="col">Inoperativos</th>
                                <th scope="col">Total</th>
                                <th scope="col">Compañia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eras as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <th>{{ $item->componente->nombre ?? 'S/D' }}</th>
                                    <th>{{ $item->marca->nombre ?? 'S/D' }}</th>
                                    <th><span
                                            class="badge badge-success">{{ $item->cantidad_operativo ?? 'S/D' }}</span>
                                    </th>
                                    <th><span
                                            class="badge badge-danger">{{ $item->cantidad_inoperativo ?? 'S/D' }}</span>
                                    </th>
                                    <th><span
                                            class="badge badge-secondary">{{ $item->cantidad_operativo + $item->cantidad_inoperativo ?? 'S/D' }}</span>
                                    </th>
                                    <th>{{ $item->compania->compania ?? 'S/D' }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
                @foreach ($eras as $item)
                    {{ $item ?? 'S/D' }}
                @endforeach
            </x-adminlte-card>
        </div>
    </div>





    {{-- </x-adminlte-card> --}}
</div>
