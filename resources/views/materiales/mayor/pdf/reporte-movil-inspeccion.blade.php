<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ficha del Móvil - CBVP</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf/materiales/mayor/reporte-movil-inspeccion.css') }}">
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
                    <strong style="font-size: 18px; font-weight: bold;">Cuerpo De Bomberos Voluntarios Del Paraguay</strong><br>
                    recepcion@cbvp.org.py | bomberoscbvp.org.py<br>
                    Dpto. Mantenimiento de Materiales<br>
                    <small>Generado el: {{ date('d / m / Y H:i') ?? 'N/A' }} Hs </small>
                </td>
                <td style="width: 25%;">
                    <img src="{{ public_path('img/dmm-cbvp-logo.png') }}" class="logo">
                </td>
            </tr>
        </table>

        <div class="subtitulo">Ficha del Móvil</div>

        <!-- {{-- Datos del móvil --}} -->
        <table class="tabla-observaciones">
            <tbody>
                <tr>
                    <td><strong>Compañía:</strong> {{ $movil->compania ?? 'S/D' }}</td>
                    <td><strong>Acrónimo:</strong> {{ $movil->tipo ?? 'S/D' }}-{{ $movil->movil ?? 'S/D' }}</td>
                    <td><strong>Marca:</strong> {{ $movil->marca ?? 'S/D' }}</td>
                    <td><strong>Modelo:</strong> {{ $movil->modelo ?? 'S/D' }}</td>
                </tr>
                <tr>
                    <td><strong>Estado:</strong> {{ $movil->operatividad ?? 'S/D' }}</td>
                    <td><strong>Transmisión:</strong> {{ $movil->transmision ?? 'S/D' }}</td>
                    <td><strong>Eje:</strong> {{ $movil->eje ?? 'S/D' }}</td>
                    <td><strong>Combustible:</strong> {{ $movil->combustible ?? 'S/D' }}</td>
                </tr>
                <tr>
                    
                    <td><strong>C. Delanteras:</strong> {{ $movil->cubiertas_frente ?? 'S/D' }}</td>
                    <td><strong>C. Traseras:</strong> {{ $movil->cubiertas_atras ?? 'S/D' }}</td>
                    <td><strong>Chapa:</strong> {{ $movil->chapa ?? 'S/D' }}</td>
                    <td><strong>Chasis:</strong> {{ $movil->chasis ?? 'S/D' }}</td>
                </tr>
            </tbody>
        </table>

        <br>
        <br>

        <div class="subtitulo">Últimas 2 Observaciones</div>

        <!-- {{-- Observaciones --}} -->
        <table class="tabla-observaciones">
            <thead>
                <tr>
                    <th>Acción:</th>
                    <th>Categoría:</th>
                    <th>Detalle:</th>
                    <th>Comentario:</th>
                    <th>Usuario:</th>
                    <th>Fecha y Hora:</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comentarios as $comentario)
                    <tr>
                        <td>{{ $comentario->accion ?? 'N/A' }}</td>
                        <td>{{ $comentario->accion_categoria ?? 'S/D' }}</td>
                        <td>{{ $comentario->categoria_detalle ?? 'S/D' }}</td>
                        <td>{{ $comentario->comentario ?? 'N/A' }}</td>
                        <td>{{ $comentario->nombrecompleto ?? 'N/A' }}</td>
                        <td>{{ date('d/m/Y H:i', strtotime($comentario->created_at)) }} Hs</td>
                    </tr>
                @empty
                    <td colspan="100%" class="text-center text-muted">No registra observaciones...</td>
                @endforelse
            </tbody>
        </table>
<br><br>
        <!-- {{-- Reporte adicional --}} -->
        <p><strong>Reporte DMM:</strong></p>
        <div class="lineas"></div>
        <div class="lineas"></div>
        <div class="lineas"></div>
        <div class="lineas"></div>

        <!-- {{-- Firma --}} -->
        <div class="firma">
            _________________________________<br>
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
