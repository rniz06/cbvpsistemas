<div>

<div class="card card-primary">

<div class="card-header">

<h3 class="card-title">

Ficha del Aspirante

</h3>

<div class="card-tools">

<button
class="btn btn-warning btn-sm"
wire:click="$toggle('modoEditar')"
>

Editar

</button>

<button
class="btn btn-danger btn-sm"
wire:click="delete"
wire:confirm="¿Dar de baja?"

>

Baja Lógica

</button>

</div>

</div>

<div class="card-body">

@if($modoEditar)

<form wire:submit.prevent="save">

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

<div class="col-md-4">

<label>

Compañía

</label>

<select
wire:model="compania_id"
class="form-control"
>

@foreach($companias as $c)

<option
value="{{ $c->id_compania }}"
>

{{ $c->compania }}

</option>

@endforeach

</select>

</div>

<div class="col-md-4">

<label>

Llamado

</label>

<select
wire:model="llamado_id"
class="form-control"
>

@foreach($llamados as $l)

<option
value="{{ $l->id }}"
>

{{ $l->nombre }}

</option>

@endforeach

</select>

</div>

<div class="col-md-4">

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

Guardar cambios

</button>

    <button
        type="button"
        class="btn btn-secondary"
        wire:click="cancelar"
    >

        Cancelar

    </button>
</form>

@else

<div class="mb-4">

<div class="d-flex justify-content-between align-items-center">

<div>

<h3 class="font-weight-bold mb-0">

{{ $aspirante->nombre }}
{{ $aspirante->apellido }}

</h3>

<div class="text-muted">

CI {{ $aspirante->cedula }}

</div>

</div>

<div>

@if($aspirante->estado=='ACTIVO')

<span class="badge badge-success px-3 py-2">

ACTIVO

</span>

@else

<span class="badge badge-secondary px-3 py-2">

{{ $aspirante->estado }}

</span>

@endif

</div>

</div>

<div class="row mt-4">

<div class="col-md-3 mb-3">

<small class="text-muted d-block">

Compañía

</small>

<strong>

{{ $aspirante->compania->compania ?? '-' }}

</strong>

</div>

<div class="col-md-3 mb-3">

<small class="text-muted d-block">

Llamado

</small>

<strong>

{{ $aspirante->llamado->nombre ?? '-' }}

</strong>

</div>

<div class="col-md-2 mb-3">

<small class="text-muted d-block">

Sexo

</small>

<strong>

@if($aspirante->sexo=='M')
Masculino
@elseif($aspirante->sexo=='F')
Femenino
@else
—
@endif

</strong>

</div>

<div class="col-md-2 mb-3">

<small class="text-muted d-block">

Nacimiento

</small>

<strong>

{{ $aspirante->fecha_nacimiento }}

</strong>

</div>

<div class="col-md-2 mb-3">

<small class="text-muted d-block">

Celular

</small>

<strong>

{{ $aspirante->celular ?: '-' }}

</strong>

</div>

<div class="col-md-6">

<small class="text-muted d-block">

Correo

</small>

<strong>

{{ $aspirante->correo ?: '-' }}

</strong>

</div>

<div class="col-md-6">

<small class="text-muted d-block">

Ciudad

</small>

<strong>

{{ $aspirante->ciudad ?: '-' }}

</strong>

</div>

</div>

</div>

@endif




<div class="card shadow-sm border-0 mt-4">

<div
class="card-header"
style="
    background:#f8f9fa;
    border-bottom:1px solid #aeb2b6f6;
    cursor:pointer;
"
style="cursor:pointer;"
wire:click="$toggle('mostrarFichaMedica')"
>

<h3 class="card-title">

@if($mostrarFichaMedica)

▼

@else

►

@endif

Ficha Médica

<span class="badge bg-dark ml-2">

{{ $this->documentosMedicosCompletos }}/4 documentos

</span>

@if(
$this->documentosMedicosCompletos==4
)

<span class="badge bg-success ml-2">

COMPLETA

</span>

@else

<span class="badge bg-warning ml-2">

INCOMPLETA

</span>

@endif

</h3>

</div>

@if($mostrarFichaMedica)

<div class="card-body">

<form
wire:submit.prevent="guardarFichaMedica"
>

<div class="card bg-light border-0 shadow-sm mb-4">

    <div class="card-body">

        <div class="row">

            <div class="col-md-4">

                <label
                    class="text-muted font-weight-bold small"
                >
                    REGISTRO MÉDICO
                </label>

                <div class="input-group">

                    <div class="input-group-prepend">

                        <span class="input-group-text">

                            <i class="fas fa-user-md"></i>

                        </span>

                    </div>

                    <input
                        wire:model="registro_medico"
                        class="form-control"
                        placeholder="Ej: 12.345 MSPBS"
                    >

                </div>

            </div>

            <div class="col-md-8">

                <label
                    class="text-muted font-weight-bold small"
                >
                    OBSERVACIONES MÉDICAS
                </label>

                <textarea
                    wire:model="observacion_medica"
                    class="form-control"
                    rows="1"
                    placeholder="Observaciones, restricciones o comentarios del profesional..."
                ></textarea>

            </div>

        </div>

    </div>

</div>

<div class="border rounded bg-white">

@include(
'livewire.anb.ecb.aspirantes.partials.documento-medico',
[
'titulo'=>'Ficha médica completa',
'campo'=>'ficha_medica_archivo',
'opcional'=>false
]
)

@include(
'livewire.anb.ecb.aspirantes.partials.documento-medico',
[
'titulo'=>'Electrocardiograma (ECG)',
'campo'=>'ecg_archivo',
'opcional'=>false
]
)

@include(
'livewire.anb.ecb.aspirantes.partials.documento-medico',
[
'titulo'=>'Radiografía de tórax',
'campo'=>'radiografia_torax_archivo',
'opcional'=>false
]
)

@include(
'livewire.anb.ecb.aspirantes.partials.documento-medico',
[
'titulo'=>'Laboratorio / análisis clínicos',
'campo'=>'laboratorio_archivo',
'opcional'=>false
]
)

@include(
'livewire.anb.ecb.aspirantes.partials.documento-medico',
[
'titulo'=>'Documentación complementaria',
'campo'=>'documentacion_complementaria_archivo',
'opcional'=>true
]
)

</div>

<div class="mt-3">

<button
type="submit"
class="btn btn-danger"
>

Guardar ficha médica

</button>

</div>

</form>

</div>

@endif

</div>









<div class="card shadow-sm border-0 mt-4">

<div
class="card-header d-flex justify-content-between align-items-center"
wire:click="$toggle('mostrarExamenesFisicos')"
style="
background:#f8f9fa;
border-bottom:1px solid #dee2e6;
cursor:pointer;
"
>

<h3 class="card-title">

@if($mostrarExamenesFisicos)
▼
@else
►
@endif

Historial de Exámenes Físicos

</h3>

</div>






@if($mostrarExamenesFisicos)

<div class="card-body">
<button
class="btn btn-success btn-sm"
wire:click="$toggle('mostrarNuevoExamen')"
>

@if($mostrarNuevoExamen)

Cancelar

@else

Agregar nuevo examen físico

@endif

</button> <hr>
@if($mostrarNuevoExamen)

<form
wire:submit.prevent="guardarExamenFisico"
>

<div class="row">

<div class="col-md-4">

<label>

Examen físico

</label>

<select
wire:model.live="examen_fisico_id"
class="form-control"
>

<option value="">

Seleccionar

</option>

@foreach($examenesFisicos as $e)

<option value="{{ $e->id }}">

{{ $e->nombre }}

</option>

@endforeach

</select>

</div>

</div>

@if($examen_fisico_id)



@php

$examen=\App\Models\ANB\ECB\ExamenFisico::with(
'pruebas'
)->find(
$examen_fisico_id
);

@endphp

@foreach(($examen?->pruebas ?? []) as $prueba)

<div class="row mb-3">

<div class="col-md-4">

<label>

{{ $prueba->nombre }}

</label>

<input
type="number"
step="0.01"
wire:model.live="resultados.{{ $prueba->id }}"
wire:keyup="calcularPuntaje"
class="form-control"
>

</div>

<div class="col-md-2">

<label>

Puntaje

</label>

<input
readonly
class="form-control"
value="{{ $resultados['puntaje_'.$prueba->id] ?? 0 }}"
>

</div>

</div>

@endforeach



<div class="row">

<div class="col-md-4">

<h4>

TOTAL

<span class="badge bg-success">

{{ $puntajeTotal }} pts

</span>

</h4>

</div>

</div>

<br>

<button
type="submit"
class="btn btn-info"
>

Guardar Examen Físico

</button>

@endif

</form>



@endif


<h5>

Historial

</h5>

<table
class="table table-bordered table-striped"
>

<thead>

<tr>

<th>

Fecha

</th>

<th>

Examen

</th>

<th>

Total

</th>

<th>

Estado

</th>

<th>

Detalle

</th>

</tr>

</thead>

<tbody>

@forelse($resultadosExamenes as $r)

<tr>

<td>

{{ $r->created_at->format('d/m/Y H:i') }}

</td>

<td>

{{ $r->examen->nombre ?? '-' }}

</td>

<td>

<span class="badge bg-success">

{{ $r->puntaje_total }} pts

</span>

</td>

<td>

@if($r->aprobado)

<span
class="badge bg-success"
>

APROBADO

</span>

@else

<span
class="badge bg-danger"
>

REPROBADO

</span>

@endif

</td>

<td>

<button
type="button"
class="btn btn-primary btn-sm"
data-toggle="collapse"
data-target="#detalle{{ $r->id }}"
>

Ver

</button>

</td>

</tr>

<tr>

<td colspan="5">

<div
id="detalle{{ $r->id }}"
class="collapse"
>

<table
class="table table-sm table-bordered"
>

<thead>

<tr>

<th>

Prueba

</th>

<th>

Resultado

</th>

<th>

Puntaje

</th>

</tr>

</thead>

<tbody>

@foreach($r->detalles as $d)

<tr>

<td>

{{ $d->prueba->nombre ?? '-' }}

</td>

<td>

{{ $d->valor_obtenido }}

</td>

<td>

{{ $d->puntaje }} pts

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</td>

</tr>

@empty

<tr>

<td
colspan="4"
class="text-center text-muted"
>

Sin exámenes registrados.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>



@endif

</div>







<div class="card shadow-sm border-0 mt-4">

<div
class="card-header d-flex justify-content-between align-items-center"
wire:click="$toggle('mostrarEvaluacionesPsico')"
style="
background:#f8f9fa;
border-bottom:1px solid #dee2e6;
cursor:pointer;
"
>

<h3 class="card-title mb-0">

@if($mostrarEvaluacionesPsico)
▼
@else
►
@endif

Evaluaciones Psicológicas

</h3>

<div>

<span class="badge badge-secondary">

{{ count($testsPsico) }}

tests

</span>

</div>

</div>

@if($mostrarEvaluacionesPsico)

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Test</th>

<th>Estado</th>

<th>Fecha</th>

<th>Puntaje</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

@foreach($testsPsico as $test)

@php
$sesion=$sesionesPsico[$test->id] ?? null;
@endphp

<tr>

<td>

{{ $test->nombre }}

</td>

<td>

@if(!$sesion)

<span class="badge bg-secondary">

PENDIENTE

</span>

@elseif($sesion->finalizado)

<span class="badge bg-success">

COMPLETADO

</span>

@else

<span class="badge bg-warning">

EN PROGRESO

</span>

@endif

</td>

<td>

{{ $sesion?->created_at?->format('d/m/Y H:i') ?? '-' }}

</td>

<td>

{{ $sesion?->puntaje ?? '-' }}

</td>

<td>

@if($sesion)

<button
class="btn btn-info btn-sm"
wire:click="abrirDetallePsico({{ $sesion->id }})"
>

Detalle

</button>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

@endif




    @if($mostrarDetallePsico)

<div
    class="modal fade show d-block"
    style="background:rgba(0,0,0,.6);"
>

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Detalle Psicológico

                </h5>

                <button
                    type="button"
                    class="close"
                    wire:click="$set('mostrarDetallePsico',false)"
                >

                    ×

                </button>

            </div>

            <div
                class="modal-body"
                style="max-height:75vh;overflow-y:auto;"
            >

                @if($detallePsico)

                    <h4>

                        {{ $detallePsico->test->nombre }}

                    </h4>

                    @if($detallePsico->test->codigo=='WONDERLIC')

                        <div class="alert alert-primary">

                            <strong>

                                Puntaje Wonderlic:

                            </strong>

                            {{ $detallePsico->puntaje }}

                            respuestas correctas

                        </div>

                    @endif

                    <div class="row mb-3">

                        <div class="col-md-4">

                            <strong>Estado</strong>

                            <br>

                            @if($detallePsico->finalizado)

                                <span class="badge bg-success">

                                    COMPLETADO

                                </span>

                            @else

                                <span class="badge bg-warning">

                                    EN PROGRESO

                                </span>

                            @endif

                        </div>

                        <div class="col-md-4">

                            <strong>Puntaje</strong>

                            <br>

                            {{ $detallePsico->puntaje ?? '-' }}

                        </div>

                        <div class="col-md-4">

                            <strong>Fecha</strong>

                            <br>

                            {{ $detallePsico->created_at?->format('d/m/Y H:i') }}

                        </div>

                    </div>

                    @if($detallePsico->test->codigo=='NEOFFI')

                        <hr>

                        <h5>

                            Resultados NEO-FFI

                        </h5>

                        <table class="table table-bordered">

                            <thead>

                                <tr>

                                    <th>Dimensión</th>

                                    <th width="120">

                                        Puntaje

                                    </th>

                                    <th width="180">

                                        Interpretación

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($detallePsico->resultados as $resultado)

                                    <tr>

                                        <td>

                                            {{ $resultado->dimension?->nombre ?? '-' }}

                                        </td>

                                        <td>

                                            <span class="badge badge-primary">

                                                {{ $resultado->puntaje }}

                                            </span>

                                        </td>

                                        <td>

                                            {{

                                                $this->interpretarNeoFfi(

                                                    $resultado->dimension?->nombre,

                                                    $resultado->puntaje

                                                )

                                            }}

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    @endif

                    @if($detallePsico->test->codigo=='LSB50')

                        <hr>

                        <h5>

                            Resultados LSB-50

                        </h5>

                        <table class="table table-bordered">

                            <thead>

                                <tr>

                                    <th>Escala</th>

                                    <th width="120">

                                        Puntaje

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($detallePsico->resultados as $resultado)

                                    <tr>

                                        <td>

                                            {{ $resultado->dimension?->nombre ?? '-' }}

                                        </td>

                                        <td>

                                            <span class="badge badge-info">

                                                {{ $resultado->puntaje }}

                                            </span>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                        <div class="alert alert-warning">

                            <strong>Nota:</strong>

                            La interpretación y el gráfico del LSB-50 deben realizarse utilizando los baremos oficiales.

                        </div>

                    @endif

                    <hr>

                    <h5>

                        Respuestas registradas

                    </h5>

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>

                                    Pregunta

                                </th>

                                <th>

                                    Respuesta elegida

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($detallePsico->respuestas as $r)

                                <tr>

                                    <td>

                                        {{ $r->pregunta?->pregunta }}

                                    </td>

                                    <td>

                                        {{ $r->opcion?->texto ?? '-' }}

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @endif

            </div>

        </div>

    </div>

</div>

@endif

   
</div>
</div>
</div>
</div>