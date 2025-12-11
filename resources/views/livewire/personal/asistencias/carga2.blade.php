 {{-- FORMULARIO DE CARGA DE ASISTENCIA DENTRO DEL MODAL --}}
 <form wire:submit.prevent="guardar">

     {{-- VOLUNTARIO --}}
     <div class="row col-md-12">
         <x-adminlte-input name="" label="Voluntario" fgroup-class="col-md-12" igroup-size="sm" readonly
             value="{{ $detalle->personal->nombrecompleto . ' | Código:' . $detalle->personal->codigo }}" />
     </div>

     <div class="row col-md-12">
         {{-- PRACTICA --}}
         <x-adminlte-input type="number" name="practica" wire:model.blur="practica" label="Práctica *" fgroup-class="col-md-4"
             igroup-size="sm" />

         {{-- GUARDIA --}}
         <x-adminlte-input type="number" name="guardia" wire:model.blur="guardia" label="Guardia *" fgroup-class="col-md-4"
             igroup-size="sm" />

         {{-- CITACION --}}
         @if ($detalle->asistencia->hubo_citacion)
             <x-adminlte-input type="number" name="citacion" wire:model.blur="citacion" label="Citación *" fgroup-class="col-md-4"
                 igroup-size="sm" />
         @endif
     </div>

     {{-- SLOT DE FOOTER VACIO DEBIDO A QUE EL COMPONENTE DEL MODAL SE ENCUENTRA EN OTRA VISTA Y GENERA FALLO AL UTILIZAR METODOS DESDE AQUI --}}
     <x-slot name="footerSlot" class="p-0"></x-slot>

     <div class="modal-footer justify-content-between p-0">
         {{-- BOTON CERRAR MODAL --}}
         <x-adminlte-button label="Cerrar" class="btn-sm" data-dismiss="modal" theme="outline-secondary"
             icon="fas fa-arrow-left" onclick="this.blur()" />

         {{-- BOTON GUARDAR --}}
         <x-adminlte-button type="submit" label="Guardar" theme="outline-success" class="btn-sm" icon="fas fa-save" />
     </div>
 </form>
