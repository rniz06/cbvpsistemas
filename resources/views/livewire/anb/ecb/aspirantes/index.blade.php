<div>

<div class="card card-secondary">

<div class="card-header">

<h3 class="card-title">

Aspirantes ECB

</h3>

<div class="card-tools">

<button
class="btn btn-success btn-sm"
wire:click="$toggle('mostrarCreate')"
>

@if($mostrarCreate)

Cancelar

@else

Nuevo Aspirante

@endif

</button>

</div>

</div>

<div class="card-body">

@if($mostrarCreate)

<div class="card card-primary mb-4">

<div class="card-header">

<h3 class="card-title">

Nuevo Aspirante

</h3>

</div>

<div class="card-body">

<form
wire:submit.prevent="save"
>

<div class="row">

<div class="col-md-4">

<label>

Llamado

</label>

<select
wire:model="llamado_id"
class="form-control"
>

<option value="">

Seleccionar

</option>

@foreach($llamados as $l)

<option value="{{ $l->id }}">

{{ $l->nombre }}

</option>

@endforeach

</select>

</div>

<div class="col-md-4">

<label>

Compañía

</label>

<select
wire:model="compania_id"
class="form-control"
>

<option value="">

Seleccionar

</option>

@foreach($companias as $c)

<option value="{{ $c->id_compania }}">

{{ $c->compania }}

</option>

@endforeach

</select>

</div>

<div class="col-md-4">

<label>

Estado

</label>

<select
wire:model="estado"
class="form-control"
>

<option value="PRE_ASPIRANTE">

PRE ASPIRANTE

</option>

<option value="ASPIRANTE">

ASPIRANTE

</option>

</select>

</div>

</div>

<br>

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

<div class="col-md-4">

<label>

Apellido

</label>

<input
wire:model="apellido"
class="form-control"
>

</div>

<div class="col-md-4">

<label>

Cédula

</label>

<input
wire:model="cedula"
class="form-control"
>

</div>

</div>

<br>

<div class="row">

<div class="col-md-3">

<label>

Celular

</label>

<input
wire:model="celular"
class="form-control"
>

</div>

<div class="col-md-3">

<label>

Correo

</label>

<input
wire:model="correo"
class="form-control"
>

</div>

<div class="col-md-3">

<label>

Ciudad

</label>

<input
wire:model="ciudad"
class="form-control"
>

</div>

<div class="col-md-3">

<label>

Fecha Nacimiento

</label>

<input
type="date"
wire:model="fecha_nacimiento"
class="form-control"
>

</div>


<div class="col-md-3">

<label>

Sexo

</label>

<select
wire:model="sexo"
class="form-control"
>

<option value="">

Seleccionar

</option>

<option value="M">

Masculino

</option>

<option value="F">

Femenino

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

<div class="row mb-3">

<div class="col-md-3">

<input
wire:model.live="buscar"
class="form-control"
placeholder="Buscar..."
>

</div>

<div class="col-md-3">

<select
wire:model.live="filtro_llamado"
class="form-control"
>

<option value="">

Todos los llamados

</option>

@foreach($llamados as $l)

<option value="{{ $l->id }}">

{{ $l->nombre }}

</option>

@endforeach

</select>

</div>

<div class="col-md-3">

<select
wire:model.live="filtro_compania"
class="form-control"
>

<option value="">

Todas las compañías

</option>

@foreach($companias as $c)

<option value="{{ $c->id_compania }}">

{{ $c->compania }}

</option>

@endforeach

</select>

</div>

<div class="col-md-3">

<select
wire:model.live="filtro_estado"
class="form-control"
>

<option value="">

Todos los estados

</option>

<option value="PRE_ASPIRANTE">

PRE ASPIRANTE

</option>

<option value="ASPIRANTE">

ASPIRANTE

</option>

</select>

</div>

</div>

<table
class="table table-bordered table-striped"
>

<thead>

<tr>

<th>Cédula</th>

<th>Nombre</th>

<th>Llamado</th>

<th>Compañía</th>

<th>Estado</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

@forelse($aspirantes as $a)

<tr>

<td>

{{ $a->cedula }}

</td>

<td>

{{ $a->nombre }}
{{ $a->apellido }}

</td>

<td>

{{ $a->llamado->nombre ?? '-' }}

</td>

<td>

{{ $a->compania->compania ?? '-' }}

</td>

<td>

@if(
$a->estado=='PRE_ASPIRANTE'
)

<span class="badge bg-warning">

PRE ASPIRANTE

</span>

@else

<span class="badge bg-success">

ASPIRANTE

</span>

@endif

</td>

<td>

<a
href="{{ route(
'anb.ecb.aspirantes.show',
$a->id
) }}"
class="btn btn-primary btn-sm"
>

Ver Ficha

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
