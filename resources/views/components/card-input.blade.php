<div class="{{ $class ?? 'col-4' }}">
    <label for="{{ $id ?? '' }}">{{ $label ?? 'campo' }}:</label>
    <input type="{{ $type ?? 'text' }}" @if (isset($id)) id="{{ $id }}" @endif
        class="form-control @error('{{ $name ?? $campo }}') is-invalid @enderror" placeholder="{{ $placeholder ?? '' }}"
        @if (isset($campo)) wire:model.live="{{ $campo }}" @endif @disabled($disabled ?? false)>
    @error($name ?? $campo)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>