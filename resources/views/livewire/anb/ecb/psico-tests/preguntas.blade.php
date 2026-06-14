<div>

<div class="card card-secondary">

<div class="card-header">

<h3 class="card-title">

Preguntas — {{ $test->nombre }}

</h3>

<div class="card-tools">

<a
href="{{ route(
'anb.ecb.psico-tests.index'
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

Nueva Pregunta

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
enctype="multipart/form-data"
>

<div class="row">

<div class="col-md-2">

<label>

Orden

</label>

<input
wire:model="orden"
type="number"
class="form-control"
>

</div>

<div class="col-md-6">

<label>

Pregunta

</label>

<textarea
wire:model="pregunta"
class="form-control"
rows="3"
></textarea>

</div>

@if($dimensiones->count())

<div class="col-md-4">

<label>

Dimensión

</label>

<select
wire:model="dimension_id"
class="form-control"
>

<option value="">

Seleccionar

</option>

@foreach($dimensiones as $dimension)

<option value="{{ $dimension->id }}">

{{ $dimension->nombre }}

</option>

@endforeach

</select>

</div>

@endif
</div>

<br>

<div class="row">

<div class="col-md-6">

<label>

Imagen (opcional)

</label>

<input
type="file"
wire:model="imagen"
class="form-control"
>

</div>

</div>

@if($imagen)

<br>

<div class="row">

<div class="col-md-4">

<img
src="{{ $imagen->temporaryUrl() }}"
class="img-fluid border rounded"
>

</div>

</div>

@endif

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

Orden

</th>

<th>

Pregunta

</th>

<th>

Dimensión

</th>

<th>

Imagen

</th>

<th>

Acciones

</th>

</tr>

</thead>

<tbody>

@forelse($preguntas as $p)

<tr>

<td>

{{ $p->orden }}

</td>

<td>

{{ $p->pregunta }}

</td>

<td>

{{ $p->dimension?->nombre ?? '-' }}

</td>

<td>

@if($p->imagen)

<img
src="{{ asset(
'storage/'.$p->imagen
) }}"
style="
max-width:120px;
max-height:120px;
"
>

@else

—

@endif

</td>

<td>

<a
href="{{ route(

'anb.ecb.psico-tests.opciones.index',

$p->id

) }}"
class="btn btn-primary btn-sm"
>

Opciones

</a>

</td>

</tr>

@empty

<tr>

<td
colspan="4"
class="text-center text-muted"
>

Sin preguntas.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>