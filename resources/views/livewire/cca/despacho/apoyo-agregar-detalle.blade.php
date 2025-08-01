<div> 
    <!-- Formulario para Agregar Detalles -->
    <form wire:submit="guardarDetalles">

        <x-adminlte-card title="Agregar Detalles" icon="fas fa-plus" theme-mode="outline" header-class="bg-success">

            <div class="row align-items-end">

                {{-- Km Final --}}
                <div class="col-md-2">
                    <x-adminlte-input type="number" name="km_final" label="Kilometraje Final:" id="myNumberInput"
                        wire:model.blur="km_final" placeholder="Kilometraje Final..." :disabled="$desperfecto" />
                </div>

                {{-- BOTON DE DESPERFECTO --}}
                <div class="form-group">
                    <x-adminlte-button :label="$desperfecto ? 'Cancelar 10.77' : '10.77'" :theme="$desperfecto ? 'secondary' : 'warning'"
                        wire:click="btndesperfecto" />
                </div>

                {{-- BOTON DE GUARDADO --}}
                <div class="col-md-2">
                    <x-adminlte-button label="Guardar" icon="fas fa-save" type="submit" theme="success"
                        class="mb-3" />
                </div>
            </div>

        </x-adminlte-card>
    </form>
</div>
