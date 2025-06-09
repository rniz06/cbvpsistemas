<div>
    @if ($mostrar)
        <!-- Modal backdrop -->
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Acción</h4>
                        <button type="button" class="close" wire:click="close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form wire:submit="save">
                        <div class="modal-body">

                            <!-- Campo Acción -->
                            <div class="form-group">
                                <label for="accion_id">Acción:</label>
                                <select wire:model.live="accion_id" class="form-control" id="accion_id">
                                    <option value="">Seleccione una acción</option>
                                    <option value="1">EN SERVICIO</option>
                                    <option value="2">FUERA DE SERVICIO</option>
                                    <option value="3">REPORTAR NOVEDAD</option>
                                    @can('Material Mayor Dar De Baja')
                                        <option value="4">DAR DE BAJA</option>
                                    @endcan
                                    @can('Material Mayor Cambiar de Compania')
                                        <option value="5">CAMBIO DE COMPAÑIA</option>
                                    @endcan
                                </select>
                                @error('accion_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($accion_id == 5)
                                <!-- Campo compania_id si la accion es CAMBIO DE COMPAÑIA -->
                                <div class="form-group">
                                    <label for="compania_id">Compañia:</label>
                                    <select wire:model.live="compania_id" class="form-control" id="compania_id"
                                        required>
                                        <option value="">Seleccione una opcion</option>
                                        @foreach ($companias as $compania)
                                            <option value="{{ $compania->idcompanias }}">{{ $compania->compania }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('compania_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <!-- Campo Comentario -->
                            <div class="form-group">
                                <label for="comentario">Comentario:</label>
                                <textarea wire:model.live="comentario" class="form-control" id="comentario" rows="4"></textarea>
                                @error('comentario')
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
