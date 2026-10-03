<div>

<div class="card card-secondary">

<div class="card-header">

<h3 class="card-title">

Exámenes Físicos

</h3>

<div class="card-tools">

<button
class="btn btn-success btn-sm"
wire:click="$toggle('mostrarCreate')"
>

@if($mostrarCreate)

Cancelar

@else

Nuevo Examen

@endif

</button>

</div>

</div>

<div class="card-body">

@if($mostrarCreate)

<div class="card card-primary mb-4">

<div class="card-header">

<h3 class="card-title">

Nuevo Examen Físico

</h3>

</div>

<div class="card-body">

<form
wire:submit.prevent="save"
>

<div class="row">

<div class="col-md-4">

<label>

Nombre

</label>

<input
wire:model="nombre"
class="form-control"
>

</div>

<div class="col-md-5">

<label>

Descripción

</label>

<input
wire:model="descripcion"
class="form-control"
>

</div>

<div class="col-md-3">

<label>

Puntaje aprobación

</label>

<input
wire:model="puntaje_aprobacion"
type="number"
class="form-control"
>

</div>

</div>

<br>

<div class="row">

<div class="col-md-3">

<div class="form-check">

<input
wire:model="activo"
class="form-check-input"
type="checkbox"
>

<label
class="form-check-label"
>

Activo

</label>

</div>

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

<div class="row mb-3">

<div class="col-md-4">

<input
wire:model.live="buscar"
class="form-control"
placeholder="Buscar..."
>

</div>

</div>

<table
class="table table-bordered table-striped"
>

<thead>

<tr>

<th>ID</th>

<th>Nombre</th>

<th>Puntaje Aprobación</th>

<th>Estado</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

@forelse($examenes as $e)

<tr>

<td>

{{ $e->id }}

</td>

<td>

{{ $e->nombre }}

</td>

<td>

{{ $e->puntaje_aprobacion ?? '-' }}

</td>

<td>

@if($e->activo)

<span class="badge bg-success">

ACTIVO

</span>

@else

<span class="badge bg-danger">

INACTIVO

</span>

@endif

</td>

<td>

<a
href="{{ route(

'anb.ecb.examenes-fisicos.pruebas.index',

$e->id

) }}"
class="btn btn-primary btn-sm"
>

Pruebas

</a>

</td>

</tr>

@empty

<tr>

<td
colspan="5"
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