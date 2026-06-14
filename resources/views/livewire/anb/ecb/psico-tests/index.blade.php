<div>

<div class="card card-secondary">

<div class="card-header">

<h3 class="card-title">

Tests Psicológicos

</h3>

<div class="card-tools">

<button
class="btn btn-success btn-sm"
wire:click="$toggle('mostrarCreate')"
>

@if($mostrarCreate)

Cancelar

@else

Nuevo Test

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

<div class="col-md-4">

<label>

Nombre

</label>

<input
wire:model="nombre"
class="form-control"
>

</div>

<div class="col-md-3">

    <label>

        Tipo de Test

    </label>

    <select
        wire:model="codigo"
        class="form-control"
    >

        <option value="">
            Seleccione
        </option>

        <option value="WONDERLIC">
            WONDERLIC
        </option>

        <option value="NEOFFI">
            NEOFFI
        </option>

        <option value="LSB50">
            LSB50
        </option>

    </select>

</div>

<div class="col-md-2">

<label>

Duración

</label>

<input
wire:model="duracion_minutos"
type="number"
class="form-control"
>

</div>

<div class="col-md-3">

<label>

Activo

</label>

<div>

<input
wire:model="activo"
type="checkbox"
>

</div>

</div>

</div>

<br>

<div class="row">

<div class="col-md-12">

<label>

Descripción

</label>

<textarea
wire:model="descripcion"
class="form-control"
></textarea>

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

<th>Código</th>

<th>Duración</th>

<th>Estado</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

@forelse($tests as $t)

<tr>

<td>

{{ $t->id }}

</td>

<td>

{{ $t->nombre }}

</td>

<td>

{{ $t->codigo }}

</td>

<td>

{{ $t->duracion_minutos ?? '-' }} min

</td>

<td>

@if($t->activo)

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

'anb.ecb.psico-tests.preguntas.index',

$t->id

) }}"
class="btn btn-primary btn-sm"
>

Preguntas

</a>

</td>

</tr>

@empty

<tr>

<td
colspan="6"
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