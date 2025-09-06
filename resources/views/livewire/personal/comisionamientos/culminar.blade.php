<div>
    <!-- Culminar Comisionamiento -->
    <h4 class="text-center">Finalizar Comisionamiento</h4>
    <x-adminlte-callout theme="warning">
        <form wire:submit="culminar" class="">

            <div class="row align-items-end">
                {{-- Nombre completo - Codigo --}}
                <div class="col-md-4">
                    <x-adminlte-input name=""
                        value="{{ $comisionamiento->nombrecompleto ?? 'S/D' }} - {{ $comisionamiento->codigo ?? 'S/D' }}"
                        label="Nombre Completo - Código De Bombero" disabled />
                </div>

                {{-- Cargo --}}
                <div class="col-md-4">
                    <x-adminlte-input name="" value="{{ $comisionamiento->cargo ?? 'S/D' }}" label="Cargo"
                        disabled />
                </div>

                {{-- Rango --}}
                <div class="col-md-4">
                    <x-adminlte-input name="" value="{{ $comisionamiento->rango ?? 'S/D' }}" label="Rango"
                        disabled />
                </div>

                {{-- Comisionado --}}
                <div class="col-md-4">
                    <x-adminlte-input name="" value="{{ $comisionamiento->compania ?? 'S/D' }}"
                        label="Comisionado" disabled />
                </div>

                {{-- Codigo Radial --}}
                <div class="col-md-4">
                    <x-adminlte-input name="" value="{{ $comisionamiento->codigo_comisionamiento ?? 'S/D' }}"
                        label="Cod. Radial" disabled />
                </div>

                {{-- Fecha Inicio --}}
                <div class="col-md-4">
                    <x-adminlte-input name=""
                        value="{{ $comisionamiento->fecha_inicio->format('d/m/Y') ?? 'S/D' }}" label="Fecha de Inicio"
                        disabled fgroup-class="col-md-4" />
                </div>

                <div class="col-md-12">
                    <x-adminlte-input name="fecha_fin" type="date" label="Fecha de Finalización"
                        wire:model.blur="fecha_fin" />
                </div>

                {{-- BOTON DE GUARDADO --}}
                <div class="col-md-2">
                    <x-adminlte-button label="Cancelar" icon="fas fa-arrow-left" theme="secondary"
                        class="mb-3" wire:click="cancelar" />
                    <x-adminlte-button label="Guardar" icon="fas fa-save" type="submit" theme="success"
                        class="mb-3" />

                </div>
            </div>
        </form>
    </x-adminlte-callout>

</div>
