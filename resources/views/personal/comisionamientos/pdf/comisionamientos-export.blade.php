<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comisionamientos - CBVP</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf/personal/comisionamientos/comisionamientos.css') }}">
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
                    Dpto. Personal<br>
                    <small>Generado el: {{ date('d / m / Y H:i') ?? 'N/A' }} Hs </small>
                </td>
                <td style="width: 25%;">
                    <img src="{{ public_path('img/cbvp-personal-logo.webp') }}" class="logo">
                </td>
            </tr>
        </table>

        <div class="subtitulo">Listado de Comisionamientos</div>

        <!-- {{-- Observaciones --}} -->
        <table class="tabla-observaciones">
            <thead>
                <tr>
                    <th>Nombre - Código:</th>
                    <th>Cargo:</th>
                    <th>Rango:</th>
                    <th>Comisionado:</th>
                    <th>En:</th>
                    <th>Códido Rad:</th>
                    <th>Culminado:</th>
                    <th>Fecha Inicio:</th>
                    <th>Fecha Fin:</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($query as $comisionamiento)
                    <tr>
                        <td>{{ $comisionamiento->nombre_codigo ?? 'N/A' }}</td>
                        <td>{{ $comisionamiento->cargo ?? 'S/D' }}</td>
                        <td>{{ $comisionamiento->rango ?? 'S/D' }}</td>
                        <td>{{ $comisionamiento->compania ?? 'S/D' }}</td>
                        <td>{{ $comisionamiento->direccion ?? '' }}</td>
                        <td>{{ $comisionamiento->codigo_comisionamiento ?? '' }}</td>
                        <td>{{ $comisionamiento->culminado ? 'SI' : 'NO' }}</td>
                        <td>{{ date('d/m/Y', strtotime($comisionamiento->fecha_inicio)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($comisionamiento->fecha_fin)) }}</td>
                    </tr>
                @empty
                    <td colspan="100%" class="text-center text-muted">Sin registros...</td>
                @endforelse
            </tbody>
        </table>
    </div>

</body>

</html>
