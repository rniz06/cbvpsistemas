<button
    type="{{ $type ?? 'button' }}"
    class="btn btn-{{ $color ?? 'success' }} {{ $class ?? '' }}"
    wire:click="{{ $click ?? false }}"
    @if (isset($confirm)) wire:confirm="{{ $confirm ?? 'Estas Seguro?' }}" @endif
    id="{{ $id ?? false }}"
    @disabled($disabled ?? false)
>
    <i class="{{ $icon ?? 'fas fa-save' }}"></i> {{ $slot }}
</button>