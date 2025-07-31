<div>
    <!-- Formulario para Agregar Comentario -->
    <form wire:submit="guardar">

        <x-adminlte-card title="Nuevo Comentario" icon="fas fa-plus" theme-mode="outline" header-class="bg-success">

            <div class="row align-items-end">

                {{-- Comentario --}}
                <div class="col-md-10">
                    {{-- Minimal --}}
                    <x-adminlte-textarea name="comentario" oninput="this.value = this.value.toUpperCase()"
                        label="Comentario:" wire:model.blur="comentario" placeholder="Comentario..." rows=1 />
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
