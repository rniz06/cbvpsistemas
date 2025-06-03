<div>
    @if ($mostrar)
        <!-- Modal backdrop -->
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Herramienta</h4>
                        <button type="button" class="close" wire:click="close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form wire:submit="save">
                        <div class="modal-body">


                            <!-- Campo Tipo -->
                            <div class="form-group">
                                <label for="tipo_id">Tipo de Herramienta</label>
                                <select wire:model="tipo_id" class="form-control" id="tipo_id">
                                    <option value="">Seleccione una opcion</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->idhidraulico_herr_tipo }}">{{ $tipo->tipo ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Campo Motor -->
                            <div class="form-group">
                                <label for="motor_id">Motor</label>
                                <select wire:model="motor_id" class="form-control" id="motor_id">
                                    <option value="">Seleccione una opcion</option>
                                    @foreach ($motores as $motor)
                                        <option value="{{ $motor->idhidraulico_herr_motor }}">
                                            {{ $motor->motor ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                                @error('motor_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Campo Marca -->
                            <div class="form-group">
                                <label for="marca_id">Marca</label>
                                <select wire:model="marca_id" class="form-control" id="marca_id">
                                    <option value="">Seleccione una opcion</option>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->idhidraulico_herr_marca }}">
                                            {{ $marca->marca ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                                @error('marca_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Campo Modelo -->
                            <div class="form-group">
                                <label for="modelo_id">Modelo</label>
                                <select wire:model="modelo_id" class="form-control" id="modelo_id">
                                    <option value="">Seleccione una opcion</option>
                                    @foreach ($modelos as $modelo)
                                        <option value="{{ $modelo->idhidraulico_herr_modelo }}">
                                            {{ $modelo->modelo ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                                @error('modelo_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- Campo Serie -->
                            <div class="form-group">
                                <label for="comentario">Serie</label>
                                <input wire:model="serie" class="form-control">
                                @error('serie')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="close">Cancelar</button>
                            <button type="submit" class="btn btn-primary"
                                wire:confirm="Are you sure you want to delete this post?">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal backdrop overlay -->
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
