<div>

<div class="card card-secondary">

<div class="card-header">

<h3 class="card-title">

Opciones

</h3>

<div class="card-tools">

<a
href="{{ route(

'anb.ecb.psico-tests.preguntas.index',

$pregunta->test_id

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

Nueva Opción

@endif

</button>

</div>

</div>

<div class="card-body">

<div class="alert alert-info">

<strong>

Pregunta:

</strong>

{{ $pregunta->pregunta }}

</div>

@if($pregunta->imagen)

<div class="mb-4">

<img
src="{{ asset(
'storage/'.$pregunta->imagen
) }}"
class="img-fluid border rounded"
style="max-height:250px;"
>

</div>

@endif

@if($mostrarCreate)

<div class="card card-primary mb-4">

<div class="card-body">

<form
wire:submit.prevent="save"
enctype="multipart/form-data"
>

<div class="row">

<div class="col-md-6">

<label>

Texto opción

</label>

<input
wire:model="texto"
class="form-control"
>

</div>

<div class="col-md-2">

<label>

Valor

</label>

<input
wire:model="valor"
type="number"
class="form-control"
>

</div>

<div class="col-md-2">

<label>

Correcta

</label>

<div>

<input
wire:model="correcta"
type="checkbox"
>

</div>

</div>

<div class="col-md-2">

<label>

Imagen

</label>

<input
wire:model="imagen"
type="file"
class="form-control"
>

</div>

</div>

@if($imagen)

<br>

<div>

<img
src="{{ $imagen->temporaryUrl() }}"
class="img-fluid border rounded"
style="max-height:180px;"
>

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

ID

</th>

<th>

Texto

</th>

<th>

Imagen

</th>

<th>

Valor

</th>

<th>

Correcta

</th>

</tr>

</thead>

<tbody>

@forelse($opciones as $o)

<tr>

<td>

{{ $o->id }}

</td>

<td>

{{ $o->texto ?? '—' }}

</td>

<td>

@if($o->imagen)

<img
src="{{ asset(
'storage/'.$o->imagen
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

{{ $o->valor ?? '-' }}

</td>

<td>

@if($o->correcta)

<span
class="badge bg-success"
>

SI

</span>

@else

<span
class="badge bg-secondary"
>

NO

</span>

@endif

</td>

</tr>

@empty

<tr>

<td
colspan="5"
class="text-center text-muted"
>

Sin opciones.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>