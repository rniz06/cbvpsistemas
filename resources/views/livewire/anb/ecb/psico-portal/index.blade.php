<div>

<div class="row justify-content-center">

<div class="col-md-10">

<div class="card card-primary">

<div class="card-header">

<h3 class="card-title">

Evaluación Psicológica

</h3>

</div>

<div class="card-body">

@if(!$aspirante)

<form wire:submit.prevent="validar">

<div class="row">

<div class="col-md-6">

<label>Documento</label>

<input
wire:model="cedula"
class="form-control"
>

@error('cedula')

<small class="text-danger">

{{ $message }}

</small>

@enderror

</div>

<div class="col-md-6">

<label>Fecha nacimiento</label>

<input
wire:model="fecha_nacimiento"
type="date"
class="form-control"
>

</div>

</div>

<br>

<button
type="submit"
class="btn btn-primary"
>

Ingresar

</button>

</form>

@else

<div class="alert alert-success">

<h5>

Identidad validada.

</h5>

</div>

<div class="text-right mb-3">

<button
class="btn btn-danger btn-sm"
wire:click="cerrarSesionPortal"
>

Cerrar sesión

</button>

</div>

<table class="table table-bordered">

<tr>

<th>Nombre</th>

<td>

{{ $aspirante->nombre }}

{{ $aspirante->apellido }}

</td>

</tr>

<tr>

<th>Documento</th>

<td>

{{ $aspirante->cedula }}

</td>

</tr>

<tr>

<th>Ciudad</th>

<td>

{{ $aspirante->ciudad }}

</td>

</tr>

<tr>

<th>Estado</th>

<td>

{{ $aspirante->estado }}

</td>

</tr>

</table>

<hr>

<h4>

Tests Disponibles

</h4>

<div class="row">

@foreach(\App\Models\ANB\ECB\PsicoTest::where('activo',true)->get() as $test)

<div class="col-md-4">

<div class="card card-outline card-primary">

<div class="card-body">

<h5>

{{ $test->nombre }}

</h5>

<p>

{{ $test->descripcion }}

</p>

@php

$estado=

$this->estadoTest(
    $test->id
);

@endphp

@if($estado=='pendiente')

<button
class="btn btn-primary btn-sm"
wire:click="iniciarTest({{ $test->id }})"
>

Empezar

</button>

@elseif($estado=='en_progreso')

<button
class="btn btn-warning btn-sm"
wire:click="iniciarTest({{ $test->id }})"
>

Continuar

</button>

<div class="mt-2">

<span
class="badge bg-warning"
>

EN PROGRESO

</span>

</div>

@else

<button
class="btn btn-success btn-sm"
disabled
>

Completado

</button>

<div class="mt-2">

<span
class="badge bg-success"
>

ENVIADO

</span>

</div>

@endif

</div>

</div>

</div>

@endforeach

</div>

@if($testActual)

<hr>

<div class="card card-success">

<div class="card-header">

<h3 class="card-title">

{{ $testActual->nombre }}

</h3>

</div>

<div class="card-body">

<div>

<strong>

Sesión activa

</strong>

<hr>

Inicio:

{{ $sesionExamen?->inicio?->format('d/m/Y H:i:s') }}

<br>

Expira:

{{ $sesionExamen?->expira_en?->format('H:i:s') }}

<br><br>

@if($segundosRestantes!==null)

<div
class="alert alert-warning"
wire:poll.1s
>

Tiempo restante:

<strong>

{{ gmdate('i:s',max(0,$segundosRestantes)) }}

</strong>

</div>

@endif

</div>

<hr>

@php

$preguntas=

$testActual
->preguntas()
->with('opciones')
->orderBy('orden')
->get();

$pregunta=

$preguntas[
$preguntaActual
]

?? null;

@endphp

@if($pregunta)
<div class="progress mb-3">

<div
class="progress-bar"
style="
width:
{{
(
($preguntaActual+1)

/

max(
1,
count($preguntas)
)

)

*100
}}%;
"
>

{{ $preguntaActual+1 }}

/

{{ count($preguntas) }}

</div>

</div>
<div class="card card-outline card-info">

<div class="card-header">

<h4>

Pregunta

{{ $preguntaActual+1 }}

/

{{ count($preguntas) }}

</h4>

</div>

<div class="card-body">

<p
style="
font-size:18px;
"
>

{{ $pregunta->pregunta }}

</p>

@if($pregunta->imagen)

<div class="mb-4">

<img
src="{{ asset('storage/'.$pregunta->imagen) }}"
class="img-fluid border rounded"
style="
max-height:350px;
"
>

</div>

@endif

@foreach($pregunta->opciones as $opcion)

<label
class="
card
p-3
mb-3
cursor-pointer
"
>

<div class="d-flex align-items-center">

<input
type="radio"
wire:model="respuestaSeleccionada"
value="{{ $opcion->id }}"
class="mr-3"
>

<div>

@if($opcion->imagen)

<img
src="{{ asset('storage/'.$opcion->imagen) }}"
style="
max-height:150px;
"
class="mb-2"
>

@endif

<div>

{{ $opcion->texto }}

</div>

</div>

</div>

</label>

@endforeach

<div class="mt-4 d-flex justify-content-between">

<div>

@if($preguntaActual>0)

<button
class="btn btn-secondary"
wire:click="preguntaAnterior"
>

Anterior

</button>

@endif

</div>

<div>

@if(

($preguntaActual+1)

<

count($preguntas)

)

<button
class="btn btn-primary"
wire:click="siguientePregunta"
>

Siguiente

</button>

@else

<button
class="btn btn-success"
wire:click="finalizarExamen"
>

Finalizar Examen

</button>

@endif

</div>

</div>

</div>

</div>

@endif

</div>

</div>

@endif

@endif

</div>

</div>

</div>

</div>

</div>