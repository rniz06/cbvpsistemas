<div>

<div class="card card-secondary">

<div class="card-header">

<h3 class="card-title">

Parámetros —

{{ $prueba->nombre }}

</h3>

<div class="card-tools">

<a
href="{{ route(

'anb.ecb.examenes-fisicos.pruebas.index',

$prueba->examen_fisico_id

) }}"
class="btn btn-default btn-sm"
>

Volver

</a>

<button
class="btn btn-success btn-sm"
wire:click="$toggle('mostrarCreate')"
>

@if($mostrarCreate)

Cancelar

@else

Nuevo Parámetro

@endif

</button>

</div>

</div>

<div class="card-body">

@if($mostrarCreate)

<div class="card card-primary mb-4">

<div class="card-body">

<form
wire:submit.prevent="save"
>

<div class="row">

<div class="col-md-3">

<label>

Sexo

</label>

<select
wire:model="sexo"
class="form-control"
>

<option value="M">

HOMBRE

</option>

<option value="F">

MUJER

</option>

</select>

</div>

<div class="col-md-3">

<label>

Valor mínimo

</label>

<input
wire:model="valor_min"
type="number"
class="form-control"
>

</div>

<div class="col-md-3">

<label>

Valor máximo

</label>

<input
wire:model="valor_max"
type="number"
class="form-control"
>

</div>

<div class="col-md-3">

<label>

Puntaje

</label>

<input
wire:model="puntaje"
type="number"
class="form-control"
>

</div>

</div>

<br>

<button
type="submit"
class="btn btn-success"
>

Guardar

</button>

</form>

</div>

</div>

@endif

<table
class="table table-bordered table-striped"
>

<thead>

<tr>

<th>

Sexo

</th>

<th>

Mínimo

</th>

<th>

Máximo

</th>

<th>

Puntaje

</th>

</tr>

</thead>

<tbody>

@forelse($parametros as $p)

<tr>

<td>

{{ $p->sexo }}

</td>

<td>

{{ $p->valor_min }}

</td>

<td>

{{ $p->valor_max }}

</td>

<td>

{{ $p->puntaje }}

</td>

</tr>

@empty

<tr>

<td
colspan="4"
class="text-center text-muted"
>

Sin registros.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>