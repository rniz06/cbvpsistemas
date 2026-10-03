<div
    class="container-fluid py-5"
    style="
        background:#f5f6f8;
        min-height:100vh;
    "
>

<div class="row justify-content-center">

<div class="col-xl-8 col-lg-9">

<div
    class="text-center mb-5"
>


<h1
    class="font-weight-bold mb-2"
    style="
        color:#b71c1c;
        font-size:38px;
    "
>

Academia Nacional de Bomberos

</h1>

<h5
    class="text-muted mb-3"
>

Portal Oficial de Postulación de Aspirantes

</h5>

<p
    class="text-muted"
    style="
        max-width:700px;
        margin:auto;
        font-size:17px;
    "
>

Complete el siguiente formulario para registrar su
postulación al llamado vigente.

Si anteriormente ya realizó una inscripción,
simplemente ingrese nuevamente su número de cédula y el
sistema recuperará automáticamente sus datos.

</p>

</div>



@if(session()->has('success'))

<div
    class="alert alert-success shadow-sm border-0"
>

<i class="fas fa-check-circle mr-2"></i>

{{ session('success') }}

</div>

@endif



<div
class="card border-0 shadow-lg"
style="
border-radius:18px;
overflow:hidden;
"
>

<div
class="card-body p-5"
>

<div
class="d-flex align-items-center mb-4"
>

<div
style="
width:42px;
height:42px;
border-radius:50%;
background:#b71c1c;
color:white;
display:flex;
align-items:center;
justify-content:center;
font-weight:bold;
font-size:20px;
margin-right:15px;
"
>

1

</div>

<div>

<h4
class="mb-1"
>

Identificación

</h4>

<small class="text-muted">

Ingrese el llamado vigente y su número de cédula.

</small>

</div>

</div>



<div class="row">

<div class="col-md-6">

<label
class="font-weight-bold"
>

Llamado vigente

</label>

<select
wire:model="llamado_id"
class="form-control form-control-lg"
>

@foreach($llamados as $l)

<option
value="{{ $l->id }}"
>

{{ $l->nombre }}

</option>

@endforeach

</select>

@error('llamado_id')

<small
class="text-danger"
>

{{ $message }}

</small>

@enderror

</div>



<div class="col-md-6">

<label
class="font-weight-bold"
>

Número de Cédula (SIN PUNTOS)

</label>

<input

wire:model.defer="cedula"

class="form-control form-control-lg"

placeholder="Ej.: 4123456"

>

@error('cedula')

<small
class="text-danger"
>

{{ $message }}

</small>

@enderror

</div>

</div>



<div
class="text-center mt-5"
>

<button

class="btn btn-danger btn-lg px-5"

wire:click="continuar"

wire:loading.attr="disabled"

>

<span
wire:loading.remove
wire:target="continuar"
>

CONTINUAR

</span>

<span
wire:loading
wire:target="continuar"
>

<i class="fas fa-spinner fa-spin"></i>

Validando...

</span>

</button>

</div>



@if($paso==2)

<hr class="my-5">

@if($registroExistente)

<div
class="card border-0 shadow-sm mb-4"
style="
background:#e8f7ef;
border-left:6px solid #28a745 !important;
"
>

<div class="card-body">

<h5
class="text-success mb-2"
>

<i class="fas fa-check-circle mr-2"></i>

Registro encontrado

</h5>

<div
class="text-muted"
>

Ya existe una postulación registrada con esta
cédula.

Revise los datos,
actualice la información que sea necesaria
y vuelva a cargar las fotografías de
su documento.

</div>

</div>

</div>

@else

<div
class="card border-0 shadow-sm mb-4"
style="
background:#eef6ff;
border-left:6px solid #007bff !important;
"
>

<div class="card-body">

<h5
class="text-primary mb-2"
>

<i class="fas fa-user-plus mr-2"></i>

Nueva Postulación

</h5>

<div
class="text-muted"
>

No encontramos registros previos para esta
cédula.

Complete el siguiente formulario para crear
su ficha como PRE ASPIRANTE.

</div>

</div>

</div>

@endif



<div
class="d-flex align-items-center mb-4"
>

<div
style="
width:42px;
height:42px;
border-radius:50%;
background:#b71c1c;
color:white;
display:flex;
justify-content:center;
align-items:center;
font-weight:bold;
font-size:20px;
margin-right:15px;
"
>

2

</div>

<div>

<h4 class="mb-1">

Datos Personales

</h4>

<small class="text-muted">

Complete la información solicitada.

</small>

</div>

</div>



<div class="row">

<div class="col-md-6">

<label class="font-weight-bold">

Nombre

</label>

<input
wire:model="nombre"
class="form-control form-control-lg"
>

@error('nombre')

<small class="text-danger">

{{ $message }}

</small>

@enderror

</div>

<div class="col-md-6">

<label class="font-weight-bold">

Apellido

</label>

<input
wire:model="apellido"
class="form-control form-control-lg"
>

@error('apellido')

<small class="text-danger">

{{ $message }}

</small>

@enderror

</div>

</div>

<br>

<div class="row"><div class="col-md-4">

    <label class="font-weight-bold">

        Fecha de nacimiento

    </label>

    <input
        type="date"
        wire:model="fecha_nacimiento"
        class="form-control form-control-lg"
    >

    @error('fecha_nacimiento')

        <small class="text-danger">

            {{ $message }}

        </small>

    @enderror

</div>

<div class="col-md-4">

    <label class="font-weight-bold">

        Sexo

    </label>

    <select
        wire:model="sexo"
        class="form-control form-control-lg"
    >

        <option value="">

            Seleccionar...

        </option>

        <option value="M">

            Masculino

        </option>

        <option value="F">

            Femenino

        </option>

    </select>

    @error('sexo')

        <small class="text-danger">

            {{ $message }}

        </small>

    @enderror

</div>

<div class="col-md-4">

    <label class="font-weight-bold">

        Celular

    </label>

    <input
        wire:model="celular"
        class="form-control form-control-lg"
    >

    @error('celular')

        <small class="text-danger">

            {{ $message }}

        </small>

    @enderror

</div>

</div>

<br>

<div class="row">

<div class="col-md-6">

    <label class="font-weight-bold">

        Correo electrónico

    </label>

    <input
        type="email"
        wire:model="correo"
        class="form-control form-control-lg"
    >

    @error('correo')

        <small class="text-danger">

            {{ $message }}

        </small>

    @enderror

</div>

<div class="col-md-6">

    <label class="font-weight-bold">

        Ciudad

    </label>

    <input
        wire:model="ciudad"
        class="form-control form-control-lg"
    >

    @error('ciudad')

        <small class="text-danger">

            {{ $message }}

        </small>

    @enderror

</div>

</div>

<br>

<div class="row">

<div class="col-md-12">

<label class="font-weight-bold">

Compañía donde desea postular

</label>

<select
wire:model="compania_id"
class="form-control form-control-lg"
>

<option value="">

Seleccione una compañía

</option>

@foreach($companias as $c)

<option
value="{{ $c->id_compania }}"
>

{{ $c->compania }} - {{ $c->ciudad->ciudad ?? '' }}

</option>

@endforeach

</select>

@error('compania_id')

<small class="text-danger">

{{ $message }}

</small>

@enderror

</div>

</div>

<hr class="my-5">

<div
class="d-flex align-items-center mb-4"
>

<div
style="
width:42px;
height:42px;
border-radius:50%;
background:#b71c1c;
color:white;
display:flex;
justify-content:center;
align-items:center;
font-weight:bold;
font-size:20px;
margin-right:15px;
"
>

3

</div>

<div>

<h4 class="mb-1">

Documentación

</h4>

<small class="text-muted">

Adjunte fotografías legibles de ambos lados de su documento.

</small>

</div>

</div>

<div class="row">

<div class="col-md-6">

<div
class="card border-0 shadow-sm h-100"
style="
border-radius:15px;
"
>

<div class="card-body text-center">

<i
class="fas fa-id-card"
style="
font-size:55px;
color:#b71c1c;
"
></i>

<h5 class="mt-3">

Cédula (Frente)

</h5>

<p class="text-muted">

Fotografía frontal del documento.

</p>

<input
type="file"
wire:model="cedula_frente"
accept="image/*"
class="form-control"
>

<div
wire:loading
wire:target="cedula_frente"
class="mt-3 text-primary"
>

Subiendo imagen...

</div>

@if($cedula_frente)

<img
src="{{ $cedula_frente->temporaryUrl() }}"
class="img-fluid rounded shadow mt-3"
style="max-height:260px;"
>

@endif

@error('cedula_frente')

<div class="text-danger mt-2">

{{ $message }}

</div>

@enderror

</div>

</div>

</div>

<div class="col-md-6">

<div
class="card border-0 shadow-sm h-100"
style="
border-radius:15px;
"
>

<div class="card-body text-center">

<i
class="fas fa-id-card-alt"
style="
font-size:55px;
color:#b71c1c;
"
></i>

<h5 class="mt-3">

Cédula (Dorso)

</h5>

<p class="text-muted">

Fotografía posterior del documento.

</p>

<input
type="file"
wire:model="cedula_atras"
accept="image/*"
class="form-control"
>

<div
wire:loading
wire:target="cedula_atras"
class="mt-3 text-primary"
>

Subiendo imagen...

</div>

@if($cedula_atras)

<img
src="{{ $cedula_atras->temporaryUrl() }}"
class="img-fluid rounded shadow mt-3"
style="max-height:260px;"
>

@endif

@error('cedula_atras')

<div class="text-danger mt-2">

{{ $message }}

</div>

@enderror

</div>

</div>

</div>

</div>

<hr class="my-5"><div
class="d-flex align-items-center mb-4"
>

<div
style="
width:42px;
height:42px;
border-radius:50%;
background:#b71c1c;
color:white;
display:flex;
justify-content:center;
align-items:center;
font-weight:bold;
font-size:20px;
margin-right:15px;
"
>

4

</div>

<div>

<h4 class="mb-1">

Declaración Jurada

</h4>

<small class="text-muted">

Antes de finalizar confirme la veracidad de la información.

</small>

</div>

</div>



<div
class="card border-0 shadow-sm"
style="
border-radius:15px;
background:#fafafa;
"
>

<div class="card-body">

<div class="custom-control custom-checkbox">

<input
type="checkbox"
id="acepta"
class="custom-control-input"
wire:model="aceptaDeclaracion"
>

<label
for="acepta"
class="custom-control-label"
style="
line-height:1.8;
"
>

Declaro bajo fe de juramento que toda la información
proporcionada en este formulario es verdadera y completa.

Asimismo autorizo al Cuerpo de Bomberos Voluntarios del Paraguay,
a utilizar estos datos exclusivamente para el proceso de selección
de aspirantes y para las verificaciones que considere necesarias.

</label>

</div>

@error('aceptaDeclaracion')

<div class="text-danger mt-3">

{{ $message }}

</div>

@enderror

</div>

</div>





<div class="text-center mt-5">

<button

wire:click="save"

wire:loading.attr="disabled"

class="btn btn-danger btn-lg px-5 py-3"

style="
border-radius:50px;
font-size:20px;
font-weight:600;
min-width:320px;
"

>

<span
wire:loading.remove
wire:target="save"
>

<i class="fas fa-paper-plane mr-2"></i>

FINALIZAR POSTULACIÓN

</span>

<span
wire:loading
wire:target="save"
>

<i class="fas fa-spinner fa-spin mr-2"></i>

Registrando...

</span>

</button>

</div>





<div
class="text-center mt-5"
>

<hr>

<p
class="text-muted mb-1"
style="
font-size:14px;
"
>

Academia Nacional de Bomberos

</p>

<p
class="text-muted"
style="
font-size:13px;
"
>

Cuerpo de Bomberos Voluntarios del Paraguay

</p>

<small
class="text-muted"
>

Los datos personales serán utilizados únicamente para el
proceso institucional de selección de aspirantes.

</small>

</div>

@endif

</div>

</div>

</div>

</div>

</div>