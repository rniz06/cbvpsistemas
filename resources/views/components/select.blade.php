<div class="form-group row">
    <label class="col-sm-2 col-form-label">{{ $label ?? 'campo' }}:</label>
    <div class="col-sm-10">
        <select class="{{ $classes ?? 'form-control' }}" @if(isset($multiple)) multiple @endif
            @if (isset($campo)) wire:model.live="{{ $campo }}" @endif
            @if (isset($name)) name="{{ $name }}" @endif
            @if (isset($required) && $required) required @endif
            @if (isset($id)) id="{{ $id }}" @endif>
            {{ $slot }}
        </select>
    </div>
</div>