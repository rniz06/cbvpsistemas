<div>
    <form wire:submit="guardar">
        <div class="row py-0">

            {{-- Nombres --}}
            <div class="col-md-6">
                <x-adminlte-input name="nombres" label="Nombres:" wire:model.blur="nombres" placeholder="EJ: JUAN MANUEL"
                    oninput="this.value = this.value.toUpperCase().trimStart()" />
            </div>

            {{-- Apellidos --}}
            <div class="col-md-6">
                <x-adminlte-input name="apellidos" label="Apellidos:" wire:model.blur="apellidos"
                    placeholder="EJ: PEREZ CACERES"
                    oninput="this.value = this.value.toUpperCase().trimStart()" />
            </div>
        </div>

        {{-- Cedula --}}
        <x-adminlte-input type="number" name="cedula" wire:model.blur="cedula" label="Número de CI (Cédula)"
            placeholder="7654321">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-address-card"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        {{-- Celular --}}
        <x-adminlte-input name="celular" wire:model.blur="celular" label="Número de celular" placeholder="0984123456"
            oninput="this.value = this.value.toUpperCase().trimStart()">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-mobile-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        {{-- Correo --}}
        <x-adminlte-input type="email" name="correo" wire:model.blur="correo"
            label="Correo electrónico (Ingrese uno válido, allí recibirá la información para continuar)"
            placeholder="correo@gmail.com" oninput="this.value = this.value.toLowerCase().trimStart()">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        {{-- Dirección Particular --}}
        <x-adminlte-input name="direccion_particular" wire:model.blur="direccion_particular"
            label="Dirección Particular (calle, barrio, ciudad)" placeholder="Santa Cecilia, Mbocayaty, Ñemby"
            oninput="this.value = this.value.toUpperCase().trimStart()">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        {{-- Direccion Laboral --}}
        <x-adminlte-input name="direccion_laboral" wire:model.blur="direccion_laboral"
            label="Dirección Laboral (calle, barrio, ciudad)" placeholder="Cruz del Defensor, Asunción, Asunción"
            oninput="this.value = this.value.toUpperCase().trimStart()">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        {{-- Compania --}}
        <x-adminlte-select name="compania_id" wire:model.blur="compania_id" label="Compañía en la que querés servir"
            igroup-size="md">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-gradient-default">
                    <i class="fas fa-building"></i>
                </div>
            </x-slot>
            <option>-- Seleccionar --</option>
            @foreach ($companias as $compania)
                <option value="{{ $compania->id_compania }}">{{ $compania->compania ?? 'S/D' }}</option>
            @endforeach
        </x-adminlte-select>

        <hr class="mb-4">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="acuerdo" wire:model.blur="acuerdo">
            <label class="form-check-label">Conozco los requisitos, cumplo con
                ellos y presentaré los documentos cuando se me solicite.</label>

        </div>
        @error('acuerdo')
            <span class="text-danger">* {{ $message }}</span>
        @enderror
        {{-- <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="acuerdo" wire:model.blur="acuerdo">
            <label class="custom-control-label" for="same-address">Conozco los requisitos, cumplo con
                ellos y presentaré los documentos cuando se me solicite</label>
        </div> --}}
        <hr class="mb-4">
        <button class="btn btn-warning btn-lg btn-block" type="submit">Enviar</button>
    </form>
</div>
