<div class="card card-danger">

    <div class="card-header">

        <h3 class="card-title">

            Recalcular evaluaciones psicológicas

        </h3>

    </div>

    <div class="card-body">

<p>

    Esta utilidad busca únicamente evaluaciones ya finalizadas que no poseen resultados calculados y las procesa automáticamente.

</p>

<div class="alert alert-info">

    ✔ Wonderlic calcula el puntaje.

    <br>

    ✔ NEOFFI recalcula todas las dimensiones.

    <br>

    ✔ LSB-50 recalcula todas las escalas.

</div>

        <button

            class="btn btn-danger"

            wire:click="recalcular"

            wire:confirm="¿Desea recalcular todas las evaluaciones psicológicas?"
            wire:loading.attr="disabled"
        >

            Recalcular Todo

        </button>

        @if(session()->has('success'))

            <div class="alert alert-success mt-3">

                {{ session('success') }}

            </div>

        @endif

    </div>

</div>