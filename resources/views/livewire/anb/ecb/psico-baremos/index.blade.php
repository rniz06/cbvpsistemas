<div>

<div class="card card-primary">

<div class="card-header">

<h3 class="card-title">

Baremos

<br>

<small>

{{ $test->nombre }}

</small>

</h3>

</div>

<div class="card-body">

<div class="row mb-4">

<div class="col-md-4">

<label>

Dimensión

</label>

<select
class="form-control"
wire:model.live="dimension_id"
>

<option value="">

Todas

</option>

@foreach($dimensiones as $dimension)

<option value="{{ $dimension->id }}">

{{ $dimension->nombre }}

</option>

@endforeach

</select>

</div>

<div class="col-md-3">

<label>

Sexo

</label>

<select
class="form-control"
wire:model.live="sexo"
>

<option value="A">

Ambos

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



<div class="card card-light mb-3">

<div class="card-body">

<div class="row">

<div class="col-md-2">

<label>

Desde

</label>

<input
type="number"
step="0.01"
wire:model="desde"
class="form-control"
>

</div>

<div class="col-md-2">

<label>

Hasta

</label>

<input
type="number"
step="0.01"
wire:model="hasta"
class="form-control"
>

</div>

<div class="col-md-2">

<label>

Percentil

</label>

<input
type="number"
wire:model="percentil"
class="form-control"
>

</div>

<div class="col-md-4">

<label>

Interpretación

</label>

<select
wire:model="interpretacion"
class="form-control"
>

<option value="">

Seleccionar

</option>

@foreach($interpretaciones as $texto)

<option value="{{ $texto }}">

{{ $texto }}

</option>

@endforeach

</select>

</div>

<div class="col-md-2 d-flex align-items-end">

<button
class="btn btn-success btn-block"
wire:click="guardar"
>

Agregar

</button>

</div>

</div>

</div>

</div>



<table
class="table table-bordered table-striped"
>

<thead>

<tr>

<th>

Dimensión

</th>

<th>

Desde

</th>

<th>

Hasta

</th>

<th>

Percentil

</th>

<th>

Interpretación

</th>
<th width="80">

Acción

</th>
</tr>

</thead>

<tbody>

@forelse($baremos as $b)

<tr>

<td>

{{ $b->dimension->nombre }}

</td>

<td>

{{ $b->desde }}

</td>

<td>

{{ $b->hasta }}

</td>

<td>

{{ $b->percentil }}

</td>

<td>

{{ $b->interpretacion }}

</td>
<td>

<button
class="btn btn-danger btn-sm"
wire:click="eliminar({{ $b->id }})"
>

<i class="fas fa-trash"></i>

</button>

</td>
</tr>

@empty

<tr>

<td
colspan="5"
class="text-center text-muted"
>

No existen baremos cargados.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>