<div>

<div class="card card-primary">

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

    {{-- CABECERA --}}

    <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">

        <div>

            <h2 class="font-weight-bold mb-1 text-uppercase">

                {{ $aspirante->nombre }} {{ $aspirante->apellido }}

            </h2>

            <div class="text-muted">

                C.I. Nº {{ number_format($aspirante->cedula,0,',','.') }}

            </div>

        </div>

        <div class="text-right">

            <span class="badge badge-warning px-3 py-2">

                {{ str_replace('_',' ',$aspirante->estado) }}

            </span>

            <div class="mt-3">

                <button
                    class="btn btn-warning btn-sm"
                    wire:click="$toggle('modoEditar')"
                >

                    <i class="fas fa-edit"></i>

                    Editar

                </button>

                <button
                    class="btn btn-info btn-sm"
                    wire:click="abrirCedula"
                >

                    <i class="fas fa-id-card"></i>

                    Documento

                </button>

                <button
                    class="btn btn-danger btn-sm"
                    wire:click="delete"
                    wire:confirm="¿Dar de baja?"
                >

                    <i class="fas fa-trash"></i>

                    Baja

                </button>

            </div>

        </div>

    </div>


    <div class="row">

        {{-- Compañía --}}

        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">

            <div class="border rounded p-3 h-100">

                <small class="text-muted">

                    <i class="fas fa-fire text-danger"></i>

                    Compañía

                </small>

                <h4 class="mb-0 mt-2">

                    {{ $aspirante->compania->compania ?? '-' }}

                </h4>

            </div>

        </div>


        {{-- Llamado --}}

        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">

            <div class="border rounded p-3 h-100">

                <small class="text-muted">

                    <i class="fas fa-bullhorn text-primary"></i>

                    Llamado

                </small>

                <h4 class="mb-0 mt-2">

                    {{ $aspirante->llamado->nombre ?? '-' }}

                </h4>

            </div>

        </div>


        {{-- Sexo --}}

        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">

            <div class="border rounded p-3 h-100">

                <small class="text-muted">

                    <i class="fas fa-user text-info"></i>

                    Sexo

                </small>

                <h4 class="mb-0 mt-2">

                    {{ $aspirante->sexo=='M' ? 'Masculino' : 'Femenino' }}

                </h4>

            </div>

        </div>


        {{-- Fecha --}}

        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">

            <div class="border rounded p-3 h-100">

                <small class="text-muted">

                    <i class="fas fa-calendar text-success"></i>

                    Nacimiento

                </small>

                <h4 class="mb-0 mt-2">

                    {{ \Carbon\Carbon::parse($aspirante->fecha_nacimiento)->format('d/m/Y') }}

                </h4>

            </div>

        </div>


        {{-- Celular --}}

        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">

            <div class="border rounded p-3 h-100">

                <small class="text-muted">

                    <i class="fas fa-phone text-success"></i>

                    Celular

                </small>

                <h5 class="mb-0 mt-2">

                    {{ $aspirante->celular ?: '-' }}

                </h5>

            </div>

        </div>


        {{-- Ciudad --}}

        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">

            <div class="border rounded p-3 h-100">

                <small class="text-muted">

                    <i class="fas fa-map-marker-alt text-danger"></i>

                    Ciudad

                </small>

                <h5 class="mb-0 mt-2">

                    {{ $aspirante->ciudad ?: '-' }}

                </h5>

            </div>

        </div>


        {{-- Correo --}}

        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">

            <div class="border rounded p-3 h-100">

                <small class="text-muted">

                    <i class="fas fa-envelope text-primary"></i>

                    Correo

                </small>

                <div class="font-weight-bold mt-2">

                    {{ $aspirante->correo ?: '-' }}

                </div>

            </div>

        </div>


        {{-- Documento --}}

        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">

            <div class="border rounded p-3 h-100">

                <small class="text-muted">

                    <i class="fas fa-id-card text-secondary"></i>

                    Documento

                </small>

<div class="d-flex justify-content-between align-items-center mt-3">

    <div>

        <i class="fas fa-circle
            {{ $aspirante->cedula_frente ? 'text-success' : 'text-danger' }}">
        </i>

        <span class="ml-1">

            Frente

        </span>

    </div>

    <div>

        <i class="fas fa-circle
            {{ $aspirante->cedula_atras ? 'text-success' : 'text-danger' }}">
        </i>

        <span class="ml-1">

            Dorso

        </span>

    </div>

</div>

            </div>

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

        <label class="text-muted font-weight-bold small">

            OBSERVACIONES MÉDICAS

        </label>

        <textarea
            wire:model="observacion_medica"
            class="form-control"
            rows="2"
            placeholder="Observaciones, restricciones o comentarios del profesional..."
        ></textarea>

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
    <th width="60">

        Nº

    </th>
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

    <td width="60" class="text-center">

        {{ $loop->iteration }}

    </td>

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

@if($mostrarCedula)

<div
    class="modal fade show d-block"
    style="background:rgba(0,0,0,.65);"
>

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="fas fa-id-card mr-2"></i>

                    Documento de Identidad

                </h5>

                <button
                    class="close"
                    wire:click="$set('mostrarCedula',false)"
                >
                    ×
                </button>

            </div>

            <div
                class="modal-body"
                style="height:75vh;overflow:auto;"
            >

                <div class="row">

                    {{-- ===========================
                         FRENTE
                    ============================ --}}

                    <div class="col-md-6">

                        <div class="card shadow-sm">

                            <div class="card-header text-center">

                                <strong>

                                    Cédula - Frente

                                </strong>

                            </div>

                            <div class="card-body text-center">

                                @if($aspirante->cedula_frente)

                                    <img
                                        src="{{ asset('storage/'.$aspirante->cedula_frente) }}"
                                        class="img-fluid img-thumbnail"
                                        style="
                                            max-height:500px;
                                            transform:rotate({{ $rotacionFrente }}deg);
                                            transition:.25s;
                                        "
                                    >

                                    <div class="mt-3">

                                        <button
                                            class="btn btn-warning btn-sm"
                                            wire:click="girarFrente"
                                        >

                                            <i class="fas fa-sync-alt"></i>

                                            Girar

                                        </button>

                                        <a
                                            href="{{ asset('storage/'.$aspirante->cedula_frente) }}"
                                            target="_blank"
                                            class="btn btn-outline-primary btn-sm"
                                        >

                                            <i class="fas fa-search-plus"></i>

                                            Abrir Original

                                        </a>

                                    </div>

                                @else

                                    <div class="alert alert-warning mb-0">

                                        No fue cargada la imagen del frente.

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                    {{-- ===========================
                         DORSO
                    ============================ --}}

                    <div class="col-md-6">

                        <div class="card shadow-sm">

                            <div class="card-header text-center">

                                <strong>

                                    Cédula - Dorso

                                </strong>

                            </div>

                            <div class="card-body text-center">

                                @if($aspirante->cedula_atras)

                                    <img
                                        src="{{ asset('storage/'.$aspirante->cedula_atras) }}"
                                        class="img-fluid img-thumbnail"
                                        style="
                                            max-height:500px;
                                            transform:rotate({{ $rotacionAtras }}deg);
                                            transition:.25s;
                                        "
                                    >

                                    <div class="mt-3">

                                        <button
                                            class="btn btn-warning btn-sm"
                                            wire:click="girarAtras"
                                        >

                                            <i class="fas fa-sync-alt"></i>

                                            Girar

                                        </button>

                                        <a
                                            href="{{ asset('storage/'.$aspirante->cedula_atras) }}"
                                            target="_blank"
                                            class="btn btn-outline-primary btn-sm"
                                        >

                                            <i class="fas fa-search-plus"></i>

                                            Abrir Original

                                        </a>

                                    </div>

                                @else

                                    <div class="alert alert-warning mb-0">

                                        No fue cargada la imagen del dorso.

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-secondary"
                    wire:click="$set('mostrarCedula',false)"
                >

                    Cerrar

                </button>

            </div>

        </div>

    </div>

</div>

@endif


   
</div>
</div>
</div>
</div>