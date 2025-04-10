<button type="{{ $type ?? 'button' }}" class="btn btn-{{ $color ?? 'success' }} {{ $class ?? '' }}">
    <i class="{{ $icon ?? 'fas fa-save' }}"></i> {{ $slot }}
</button>