<div class="callout callout-{{ $color ?? 'success' }} {{ $class ?? '' }}">
    @if (isset($titulo))
        <h5>{{ $titulo }}</h5>
    @endif
    <p>{{ $slot }}</p>
</div>
