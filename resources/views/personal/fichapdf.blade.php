<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBVP Ficha {{ $personal->nombrecompleto ?? '' }} - {{ $personal->codigo ?? '' }} -
        {{ $personal->categoria->categoria ?? '' }}</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf/personal/fichapdf.css') }}">
</head>

<body>
    <div class="container">
        <!-- Cabecera -->
        <div class="header">
            <img src="{{ public_path('img/cbvp-logo.png') }}" alt="Logo CBVP">
            <h1>Cuerpo De Bomberos Voluntarios Del Paraguay</h1>
            <p>info@cbvp.org.py | www.bomberoscbvp.org.py</p>
            <p>Departamento De Personal</p>
            <p>Cruz del Defensor 937 c/ Dr. Emilio Hassler</p>
            <p>Reporte Generado el: {{ date('d/m/Y H:i') ?? 'N/A' }} Hs</p>
            {{-- <p>Generado Por: {{ $usuario->name ?? 'N/A' }}</p> --}}
        </div>

        <!-- Datos del Personal -->
        <div class="section">
            <h2>Datos del Personal</h2>
            <table class="table">
                <tr>
                    <td>Nombre:</td>
                    <td>{{ $personal->nombrecompleto ?? 'N/A' }}</td>
                    <td>Categoría:</td>
                    <td>{{ $personal->categoria->categoria ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Código:</td>
                    <td>{{ $personal->codigo ?? 'N/A' }}</td>
                    <td>Estado:</td>
                    <td>{{ $personal->estado->estado ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Documento:</td>
                    <td>{{ $personal->documento ?? 'N/A' }}</td>
                    <td>Sexo:</td>
                    <td>{{ $personal->sexo->sexo ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Juramento:</td>
                    <td>{{ $personal->fecha_juramento ?? 'N/A' }}</td>
                    <td>País:</td>
                    <td>{{ $personal->pais->pais ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Compañía:</td>
                    <td>{{ $personal->compania->compania ?? 'N/A' }}</td>
                    <td>Grupo Sanguíneo:</td>
                    <td>{{ $personal->grupoSanguineo->grupo_sanguineo ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <!-- Contacto -->
        <div class="section">
            <h2>Contacto</h2>
            <table class="table">

                @forelse ($contactos as $contacto)
                    <tr>
                        <td>{{ $contacto->tipoContacto->tipo_contacto ?? 'N/A' }}</td>
                        <td>{{ $contacto->contacto ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td style="text-align: center; font-style: italic;">No Se Registran Datos...</td>
                    </tr>
                @endforelse
            </table>
        </div>

        <!-- Contacto De Emergencia-->
        <div class="section">
            <h2>Contactos De Emergencia</h2>
            <table class="table">
                @forelse ($contactosEmergencias as $contactoEmergencia)
                    <tr>
                        <td>{{ $contactoEmergencia->parentesco->parentesco ?? 'N/A' }}</td>
                        <td>{{ $contactoEmergencia->nombre_completo ?? 'N/A' }}</td>
                        <td>{{ $contactoEmergencia->tipoContacto->tipo_contacto ?? 'N/A' }}</td>
                        <td>{{ $contactoEmergencia->contacto ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td style="text-align: center; font-style: italic;">No Se Registran Datos...</td>
                    </tr>
                @endforelse

            </table>
        </div>
    </div>

</html>