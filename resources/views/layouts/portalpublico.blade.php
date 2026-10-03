<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>

        {{ $title ?? 'CBVP - Portal Público' }}

    </title>

    <link
        rel="icon"
        href="{{ asset('favicon.ico') }}"
    >

    {{-- Bootstrap 5 --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- FontAwesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    @livewireStyles

    <style>

        body{

            background:#eef2f7;

            font-family:
                "Segoe UI",
                sans-serif;

        }

        .portal-header{

            background:white;

            box-shadow:
                0 3px 15px rgba(0,0,0,.08);

        }

        .portal-logo{

            width:65px;

        }

        .portal-title{

            color:#b71c1c;

            font-weight:700;

        }

        .portal-subtitle{

            color:#6c757d;

        }

        .card-portal{

            border:none;

            border-radius:20px;

            box-shadow:

                0 10px 35px rgba(0,0,0,.08);

        }

        .btn-cbvp{

            background:#b71c1c;

            color:white;

            border-radius:50px;

            padding:

                12px 40px;

            font-weight:600;

        }

        .btn-cbvp:hover{

            background:#9e1818;

            color:white;

        }

        .step-circle{

            width:48px;

            height:48px;

            border-radius:50%;

            background:#b71c1c;

            color:white;

            display:flex;

            align-items:center;

            justify-content:center;

            font-weight:bold;

            font-size:20px;

        }

        footer{

            color:#888;

            font-size:14px;

        }

    </style>

</head>

<body>

<header class="portal-header py-3 mb-5">

<div class="container">

<div class="d-flex align-items-center">

<img

    src="{{ asset('images/logo_cbvp.png') }}"

    class="portal-logo me-3"

    onerror="this.style.display='none'"

>

<div>

<h3 class="portal-title mb-0">

Cuerpo de Bomberos Voluntarios del Paraguay

</h3>

<div class="portal-subtitle">

Academia Nacional de Bomberos

</div>

</div>

</div>

</div>

</header>

<main>

{{ $slot }}

</main>

<footer class="text-center mt-5 mb-4">

CBVP Sistemas © {{ date('Y') }}

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@livewireScripts

</body>

</html>