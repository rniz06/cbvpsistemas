<!-- resources/views/components/filter-card.blade.php -->
@props([
    'title' => 'Filtros de Búsqueda',
    'icon' => 'fas fa-filter',
    'class' => '',
])

<div class="col-md-12 {{ $class }}">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                @if ($icon)
                    <i class="{{ $icon }}"></i>
                @endif
                {{ $title }}
            </h3>
        </div>
        <div class="card-body">
            {{ $slot }}
        </div>
    </div>
</div>
