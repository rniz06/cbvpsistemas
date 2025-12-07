<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Asistencia - CBVP</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf/personal/asistencias/asistencia-para-remitir.css') }}">
</head>

<body>

    <div class="contenedor">

        <!-- {{-- Encabezado con logos --}} -->
        <table class="tabla-encabezado">
            <tr>
                <td style="width: 25%;">
                    <img src="{{ public_path('img/cbvp-logo.png') }}" class="logo">
                </td>
                <td style="width: 50%;">
                    <strong style="font-size: 18px; font-weight: bold;">Cuerpo De Bomberos Voluntarios Del
                        Paraguay</strong><br>
                    recepcion@cbvp.org.py | bomberoscbvp.org.py<br>
                    Departamento de Personal<br>
                    <small>Generado el: {{ date('d / m / Y H:i') ?? 'N/A' }} Hs </small>
                </td>
                <td style="width: 25%;">
                    <img src="{{ public_path('img/cbvp-personal-logo.webp') }}" class="logo">
                </td>
            </tr>
        </table>

        <div class="subtitulo">Asistencia periodo xxxxx/xxxx Compania: xx</div>

        <!-- {{-- Observaciones --}} -->
        <table class="tabla-observaciones">
            <thead>
                <tr>
                    <th>Voluntario:</th>
                    <th>Código:</th>
                    <th>Práctica:</th>
                    <th>Guardia:</th>
                    <th>Citación:</th>
                    <th>Total:</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($query as $asistencia)
                    <tr>
                        <td>{{ $asistencia->personal->nombrecompleto ?? 'S/D' }}</td>
                        <td>{{ $asistencia->personal->codigo ?? 'S/D' }}</td>
                        <td>{{ $asistencia->practica ?? 'S/D' }}</td>
                        <td>{{ $asistencia->guardia ?? 'S/D' }}</td>
                        <td>{{ $asistencia->citacion ?? 'NO' }}</td>
                        <td>{{ $asistencia->total ?? 'S/D' }}</td>
                    </tr>
                @empty
                    <td colspan="100%" class="text-center text-muted">Sin registros...</td>
                @endforelse
            </tbody>
        </table>

        <br><br>
        <!-- {{-- Firma --}} -->
        <div class="firma">
            ________________________________<br>
            Emitido por: {{ $usuario->nombrecompleto ?? 'S/D' }}<br>
            @php
                $letraCategoria = $usuario->categoria ? substr($usuario->categoria, 0, 1) : 'N/A';
                $codigo = $usuario->codigo ?? 'N/A';
            @endphp
            <small>{{ "$letraCategoria-$codigo" }}</small>
        </div>
    </div>

</body>

</html>
