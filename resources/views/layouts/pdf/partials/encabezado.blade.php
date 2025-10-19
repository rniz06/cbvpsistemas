<!-- {{-- Encabezado con logos --}} -->
<table class="tabla-encabezado">
    <tr>
        <td style="width: 25%;">
            <img src="{{ $logo_izq }}" class="encabezado-logo">
        </td>
        <td style="width: 50%;">
            <strong style="font-size: 18px; font-weight: bold;">Cuerpo De Bomberos Voluntarios Del
                Paraguay</strong><br>
            recepcion@cbvp.org.py | bomberoscbvp.org.py<br>
            
            @hassection('departamento')
                @yield('departamento')<br>
            @endif
            <small>Generado el: {{ date('d / m / Y H:i') ?? 'N/A' }} Hs </small>
        </td>
        <td style="width: 25%;">
            <img src="{{ $logo_der }}" class="encabezado-logo">
        </td>
    </tr>
</table>
