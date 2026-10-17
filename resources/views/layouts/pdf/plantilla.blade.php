<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ config('adminlte.title') }} @hasSection('titulo')
           - @yield('titulo')
        @endif
    </title>
    {{-- CSS base (siempre presente) --}}
    <link rel="stylesheet" href="{{ public_path('css/pdf/partials/encabezado.css') }}">
    <link rel="stylesheet" href="{{ public_path('css/pdf/plantilla.css') }}">
    {{-- CSS opcionales --}}
    @stack('styles')
    <style>
    .footer-pdf {
        position: fixed;
        bottom: 10px;
        left: 0;
        right: 0;
        width: 100%;
        text-align: center;
        font-size: 9px;
        color: #666;
    }
</style>
</head>

<body>
    {{-- Encabezado común --}}
    @include('layouts.pdf.partials.encabezado', [
        'logo_izq' => $logo_izq ?? config('logos.cbvp'),
        'logo_der' => $logo_der ?? config('logos.132'),
    ])

    <main class="contenedor">
        @yield('contenido')
    </main>
<div class="footer-pdf">
    SINABOM - Sistema Nacional de Bomberos - Desarrollado por el Dpto. de TI
</div>
</body>

</html>
