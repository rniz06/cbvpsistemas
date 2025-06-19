@props([
    'titulo' => '',
    'colClass' => 'col-md-3 col-sm-6 mb-3',  // Clase para la columna (configurable)
    'cardClass' => '',                       // Clases adicionales para la card
    'titleClass' => 'text-muted mb-0',       // Clases para el título
    'contentClass' => ''                     // Clases para el contenido
])

<div class="{{ $colClass }}">
    <div class="card h-100 {{ $cardClass }}">
        <div class="card-body p-2">
            <h6 class="card-title {{ $titleClass }}">{{ $titulo }}</h6>
            <p class="card-text {{ $contentClass }}">{{ $slot }}</p>
        </div>
    </div>
</div>