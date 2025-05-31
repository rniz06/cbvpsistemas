<button
    type="{{ $type ?? 'button' }}"
    class="btn btn-{{ $color ?? 'success' }} {{ $class ?? '' }}"
    wire:click="{{ $click ?? false }}"
    wire:confirm="{{ $confirm ?? false }}"
    id="{{ $id ?? false }}"
    @disabled($disabled ?? false)
>
    <i class="{{ $icon ?? 'fas fa-save' }}"></i> {{ $slot }}
</button>