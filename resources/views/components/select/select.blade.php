<div class="form-group">
    @if (isset($label))
        <label>{{ $label }}:</label>
    @endif
    <select class="{{ $classes ?? 'form-control' }}" @if (isset($multiple)) multiple @endif
        @if (isset($campo)) wire:model.live="{{ $campo }}" @endif
        @if (isset($name)) name="{{ $name }}" @endif
        @if (isset($required) && $required) required @endif
        @if (isset($id)) id="{{ $id }}" @endif>
        {{ $slot }}
    </select>
</div>
