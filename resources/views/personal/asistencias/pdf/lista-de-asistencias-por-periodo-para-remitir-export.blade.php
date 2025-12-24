<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Asistencia - CBVP</title>
    <link rel="stylesheet" href="{{ asset('css/pdf/personal/asistencias/asistencia-para-remitir.css') }}">
</head>

<body>

    <div class="contenedor">

        <!-- {{-- Encabezado con logos --}} -->
        <table class="tabla-encabezado">
            <tr>
                <td style="width: 25%;">
                    <img src="{{ asset('img/cbvp-logo.png') }}" class="logo">
                </td>
                <td style="width: 50%;">
                    <strong style="font-size: 18px; font-weight: bold;">Cuerpo De Bomberos Voluntarios Del
                        Paraguay</strong><br>
                    recepcion@cbvp.org.py | bomberoscbvp.org.py<br>
                    Departamento de Personal<br>
                    <small>Generado el: {{ date('d / m / Y H:i') ?? 'S/D' }} Hs </small>
                </td>
                <td style="width: 25%;">
                    <img src="{{ asset('img/cbvp-personal-logo.webp') }}" class="logo">
                </td>
            </tr>
        </table>

        <div class="subtitulo">Planilla de asistencia correspondiente al Mes de {{ $periodo ?? 'S/D' }} Compania: {{ $compania ?? 'S/D' }}
        </div>

        <!-- {{-- Observaciones --}} -->
        <table class="tabla-observaciones">
            <thead>
                <tr>
                    <th>Voluntario:</th>
                    <th>Código:</th>
                    <th>Práctica:</th>
                    <th>Guardia:</th>
                    @if ($hubo_citacion == true)
                        <th>Citación:</th>
                    @endif
                    <th>Total:</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($query as $asistencia)
                    <tr>
                        <td>{{ $asistencia->personal->nombrecompleto ?? 'S/D' }}</td>
                        <td>{{ $asistencia->personal->categoria_codigo_juramento ?? 'S/D' }}</td>
                        <td>{{ $asistencia->practica ?? 'S/D' }}</td>
                        <td>{{ $asistencia->guardia ?? 'S/D' }}</td>
                        @if ($hubo_citacion == true)
                            <td>{{ $asistencia->citacion ?? 'NO' }}</td>
                        @endif
                        <td>{{ $asistencia->total ?? 'S/D' }}</td>
                    </tr>
                @empty
                    <td colspan="100%" class="text-center text-muted">Sin registros...</td>
                @endforelse
            </tbody>
        </table>

        <br><br>

        {{-- FIRMAS --}}
        <div class="firmas">

            <table>
                <thead>
                    <tr>

                        <!-- Firma izquierda -->
                        <td class="firma" style="text-align: left;">
                            ________________________________<br>
                        </td>

                        <td style="padding-left: 17.5rem"></td> <!-- 17.5rem = 280px -->

                        <!-- Firma derecha -->
                        <td class="firma" style="text-align: right;">
                            ________________________________<br>
                            Emitido por: {{ $usuario->nombrecompleto ?? 'S/D' }}<br>
                            @php
                                $letraCategoria = $usuario->categoria ? substr($usuario->categoria, 0, 1) : 'N/A';
                                $codigo = $usuario->codigo ?? 'N/A';
                            @endphp
                            <small>{{ "$letraCategoria-$codigo" }}</small>
                        </td>

                    </tr>
                </thead>
            </table>
        </div>

        {{-- <div class="firma">
            ________________________________<br>
            Emitido por: {{ $usuario->nombrecompleto ?? 'S/D' }}<br>
            @php
                $letraCategoria = $usuario->categoria ? substr($usuario->categoria, 0, 1) : 'N/A';
                $codigo = $usuario->codigo ?? 'N/A';
            @endphp
            <small>{{ "$letraCategoria-$codigo" }}</small>
        </div> --}}
    </div>

    <script type="text/php">
            if (isset($pdf)) {
            $pdf->page_script('
            // Fuente
            $font = $fontMetrics->get_font("Arial", "normal");
            $size = 9;
            $color = [0,0,0];

            // Margenes usados en @page
            $marginLeft = 36;   // 3rem
            $marginRight = 36;  // 3rem
            $marginBottom = 48; // 3rem

            // --- Texto izquierda ---
            $leftText = "Departamento de TI a través del Sistema Nacional de Bomberos | https://sinabom.cbvp.org.py";
            $leftX = $marginLeft;
            $leftY = $pdf->get_height() - $marginBottom + 20; // posición dentro del footer

            $pdf->text($leftX, $leftY, $leftText, $font, $size, $color);

            // --- Número de página (derecha) ---
            $pageText = "Página " . $PAGE_NUM . " / " . $PAGE_COUNT;
            $textWidth = $fontMetrics->getTextWidth($pageText, $font, $size);

            $rightX = $pdf->get_width() - $marginRight - $textWidth;
            $rightY = $leftY;

            $pdf->text($rightX, $rightY, $pageText, $font, $size, $color);
            ');
        }
    </script>

</body>

</html>
