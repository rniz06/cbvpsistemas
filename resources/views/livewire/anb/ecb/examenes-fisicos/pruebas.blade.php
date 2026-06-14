<div>

<div class="card card-secondary">

<div class="card-header">

<h3 class="card-title">

Pruebas —

{{ $examen->nombre }}

</h3>

<div class="card-tools">

<a
href="{{ route(

'anb.ecb.examenes-fisicos.index'

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

Nueva Prueba

@endif

</button>

</div>

</div>

<div class="card-body">

@if($mostrarCreate)

<div class="card card-primary mb-4">

<div class="card-header">

<h3 class="card-title">

Nueva Prueba

</h3>

</div>

<div class="card-body">

<form
wire:submit.prevent="save"
>

<div class="row">

<div class="col-md-6">

<label>

Nombre

</label>

<input
wire:model="nombre"
class="form-control"
placeholder="Cooper"
>

</div>

<div class="col-md-6">

<label>

Tipo Medición

</label>

<select
wire:model="tipo_medicion"
class="form-control"
>

<option value="DISTANCIA">

DISTANCIA

</option>

<option value="REPETICIONES">

REPETICIONES

</option>

<option value="TIEMPO">

TIEMPO

</option>

</select>

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

ID

</th>

<th>

Nombre

</th>

<th>

Tipo

</th>

<th>

Acciones

</th>

</tr>

</thead>

<tbody>

@forelse($pruebas as $p)

<tr>

<td>

{{ $p->id }}

</td>

<td>

{{ $p->nombre }}

</td>

<td>

{{ $p->tipo_medicion }}

</td>

<td>

<a
href="{{ route(

'anb.ecb.examenes-fisicos.parametros.index',

$p->id

) }}"
class="btn btn-primary btn-sm"
>

Parámetros

</a>

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