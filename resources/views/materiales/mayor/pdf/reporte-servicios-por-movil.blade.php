<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $nombre_archivo ?? 'Documento' }}</title>
    {{-- <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            /* margin: 12px; */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 4px 6px;
            text-align: left;
        }

        th {
            background-color: #e0e0e0;
        }

        .center {
            text-align: center;
        }
    </style> --}}
    <link rel="stylesheet" href="{{ public_path('css/pdf/pdf-general.css') }}">
</head>

<body>
    <h2>{{ $nombre_archivo ?? 'Documento' }}</h2>

    <table>
        <thead>
            <tr>
                <th>Móvil:</th>
                <th>Compañía:</th>
                <th>Servicio:</th>
                <th>Fecha y Hora:</th>
                <th>Conductor:</th>
                <th>A cargo:</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datos as $servicio)
                <tr>
                    <td>{{ $servicio->movil ?? 'S/D' }}</td>
                    <td>{{ $servicio->compania ?? 'S/D' }}</td>
                    <td>{{ $servicio->servicio ?? 'S/D' }}</td>
                    <td>{{ date('d/m/Y H:i:s', strtotime($servicio->fecha_alfa)) }} Hs.</td>
                    {{-- Chofer --}}
                    <td>
                        @if ($servicio->chofer_rentado == 1)
                            <span class="badge badge-secondary">Rentado</span>
                        @elseif (!empty($servicio->chofer_nombrecompleto))
                            {{ $servicio->chofer_nombrecompleto ?? 'S/D' }} - {{ $servicio->chofer_codigo ?? 'S/D' }} -
                            {{ $servicio->chofer_categoria ?? 'S/D' }}
                        @elseif (!empty($servicio->chofer_aux))
                            {{ $servicio->chofer_aux }}
                        @else
                            S/D
                        @endif
                    </td>

                    {{-- A cargo --}}
                    <td>
                        @if (empty($servicio->acargo_nombrecompleto) && !empty($servicio->acargo_aux))
                            {{ $servicio->acargo_aux }}
                        @elseif (!empty($servicio->acargo_nombrecompleto))
                            {{ $servicio->acargo_nombrecompleto ?? 'S/D' }} - {{ $servicio->acargo_codigo ?? 'S/D' }}
                            -
                            {{ $servicio->acargo_categoria ?? 'S/D' }}
                        @else
                            S/D
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h4>Cantidad Total de Servicios: {{ $datos->count() ?? 'S/D' }}</h4>
</body>

</html>
