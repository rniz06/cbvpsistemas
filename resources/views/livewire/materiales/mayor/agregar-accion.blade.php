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
                                <label for="accion_id">Acción</label>
                                <select wire:model="accion_id" class="form-control" id="accion_id">
                                    <option value="">Seleccione una acción</option>
                                    @foreach ($acciones as $accion)
                                        <option value="{{ $accion->id_accion }}">{{ $accion->accion }}</option>
                                    @endforeach
                                </select>
                                @error('accion_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Campo Comentario -->
                            <div class="form-group">
                                <label for="comentario">Comentario</label>
                                <textarea wire:model="comentario" class="form-control" id="comentario" rows="4"></textarea>
                                @error('comentario')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="close">Cancelar</button>
                            <button type="submit" class="btn btn-primary" wire:confirm="Are you sure you want to delete this post?">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal backdrop overlay -->
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
