<div>

<div class="card card-secondary">

<div class="card-header">

<h3 class="card-title">

Llamados ECB

</h3>

<div class="card-tools">

<button
class="btn btn-success btn-sm"
wire:click="$toggle('mostrarCreate')"
>

@if($mostrarCreate)

Cancelar

@else

Nuevo Llamado

@endif

</button>

</div>

</div>

<div class="card-body">

@if($mostrarCreate)

<div class="card card-primary mb-4">

<div class="card-header">

<h3 class="card-title">

Nuevo Llamado

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
placeholder="Primer llamado 2026"
>

</div>

<div class="col-md-3">

<label>

Año

</label>

<input
wire:model="anio"
type="number"
class="form-control"
>

</div>

<div class="col-md-3 d-flex align-items-end">

<button
type="submit"
class="btn btn-success w-100"
>

Guardar

</button>

</div>

</div>

</form>

</div>

</div>

@endif

<div class="row mb-3">

<div class="col-md-4">

<input
wire:model.live="buscar"
class="form-control"
placeholder="Buscar llamado..."
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

<th>Año</th>

<th>Estado</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

@forelse($llamados as $llamado)

<tr>

<td>

{{ $llamado->id }}

</td>

<td>

{{ $llamado->nombre }}

</td>

<td>

{{ $llamado->anio }}

</td>

<td>

@if($llamado->activo)

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

—

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