@props([
    'label'     => 'Acciones',
    'size'      => 'xs',
    'icon'      => 'fas fa-ellipsis-v',
    'theme'     => 'secondary', // colores: primary, secondary, success, danger, etc.
])

<div class="btn-group">
    <button type="button" class="btn btn-{{ $theme }} btn-{{ $size }} dropdown-toggle"
        data-toggle="dropdown" aria-expanded="false">
        {{ $label }}
    </button>

    <div class="dropdown-menu">
        {{ $slot }}
    </div>
</div>