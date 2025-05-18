<button type="{{ $type ?? 'button' }}" class="btn btn-{{ $color ?? 'success' }} {{ $class ?? '' }}"
    @if (isset($click)) wire:click="{{ $click }}" @endif @disabled($disabled ?? false)
    @if (isset($confirm)) wire:confirm="{{ $confirm }}" @endif
    @if (isset($id)) id="{{ $id }}" @endif>
    <i class="{{ $icon ?? 'fas fa-save' }}"></i> {{ $slot }}
</button>
