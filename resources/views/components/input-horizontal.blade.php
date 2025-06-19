<div class="form-group row">
    <label for="{{ $id ?? '' }}" class="col-sm-2 col-form-label">{{ $label ?? 'Campo' }}:</label>
    <div class="col-sm-10">
        <input type="{{ $type ?? 'text' }}" class="form-control"
            @if (isset($id)) id="{{ $id }}" @endif 
            @if (isset($name)) name="{{ $name }}" @endif
            @if (isset($placeholder)) placeholder="{{ $placeholder }}" @endif
            @if (isset($campo)) wire:model.live="{{ $campo }}" @endif
            value="{{ old($name ?? $campo, $value ?? '') }}"
            @if (isset($disabled)) disabled @endif
            @if (isset($required)) required @endif>
        @error($name ?? $campo)
            <p class="text-danger">*{{ $message }}</p>
        @enderror
    </div>
</div>
