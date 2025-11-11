<div>
    <ul>
        @forelse ($auditorias as $auditoria)
            <li>Usuario: {{ $auditoria->user->nombrecompleto ?? 'S/D' }} | Fecha Hora:
                {{ optional($auditoria->created_at)->format('d/m/Y H:i:s') ?? 'S/D' }}</li>

        @empty
            <li>Sin registros</li>
        @endforelse
    </ul>
</div>
