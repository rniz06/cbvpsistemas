<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>CBVP - Quiero Ser Bombero</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/checkout/">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('img/cbvp-logo.webp') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    {{-- <meta name="theme-color" content="#563d7c"> --}}


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body class="bg-light">

    @if ($message = Session::get('success'))
        <div class="container pt-5">
            <div class="callout callout-success">
                <h5><i class="fas fa-check-circle" style="color: #1e7e34"></i> Felicidades, Haz completado
                    satisfactoriamente el Formulario de Pre Inscripción!</h5>

                <p>Mas Información al correo Ingresado en el Formulario.</p>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="py-3 text-center">
            <img class="d-block mx-auto mb-4" src="{{ asset('img/cbvp-logo.webp') }}" alt="" width="72"
                height="72">
            <h2>Quiero ser Bombero</h2>
            <p class="lead">Formulario de pre-inscripción online para Postulante a Aspirante a Bombero Voluntario
                Combatiente del Cuerpo de Bomberos Voluntarios del Paraguay</p>
        </div>

        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    {{-- <span class="text-muted">Información Adicional</span> --}}
                    <span class="text-muted">Archivos Útiles</span>

                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <a href="{{ Storage::url('anb/SOLICITUD-DE-INGRESO-2025.pdf') }}" class="text-dark">
                            <h6 class="my-0">Solicitud de Ingreso</h6>
                        </a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <a href="{{ Storage::url('anb/FICHA-MEDICA-2025.pdf') }}" class="text-dark">
                            <h6 class="my-0">Ficha Médica</h6>
                        </a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <a href="{{ Storage::url('anb/DECLARACION-JURADA-2025.pdf') }}" class="text-dark">
                            <h6 class="my-0">Declaración Jurada</h6>
                        </a>
                    </li>
                </ul>

                <h5 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Los requisitos para postularte como BVC son:</span>
                </h5>
                <ul>
                    <li>Nacionalidad paraguaya (se presentará copia de CI) o en caso de extranjero deberá presentar los
                        documentos de identidad correspondientes.</li>
                    <li>Tener 18 años cumplidos.</li>
                    <li>Edad máxima: 45 años.</li>
                    <li>Ocupación: estudiante y/o empleado (se deberá presentar constancia de estudios y/o laboral
                        respectivamente).</li>
                    <li>Poseer antecedentes policiales limpios (se deberá presentar dicho documento)</li>
                    <li>No tener impedimento físico o de salud para realizar ejercicios físicos pesados (se deberá
                        presentar certificado médico de capacidad física).</li>
                    <li>Tener un estado físico de fuerza y resistencia óptimos (se realizará prueba física para la
                        admisión).</li>
                    <li>Pasar el test psicotécnico.</li>
                </ul>
            </div>

            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Formulario</h4>
                @livewire('anb.quiero-ser-bombero')
            </div>
        </div>
        <hr class="mb-1">
        <footer class=" pt-1 text-muted text-center text-small">
            <p class="mb-1">&copy; {{ date('Y') }} Departamento de TI | CBVP</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="https://cbvp.org.py" class="text-muted">cbvp.org.py</a></li>
                <li class="list-inline-item">recepcion@cbvp.org.py</li>
            </ul>
        </footer>
    </div>

</body>

</html>
