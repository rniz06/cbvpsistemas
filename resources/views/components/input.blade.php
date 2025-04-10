<div class="form-group row">
    <label for="{{ $id ?? '' }}" class="col-sm-2 col-form-label">{{ $label ?? 'campo' }}:</label>
    <div class="col-sm-10">
        <input type="{{ $type ?? 'text' }}" class="form-control"
            @if (isset($id)) id="{{ $id }}" @endif name="{{ $name }}"
            placeholder="{{ $placeholder ?? '' }}" value="{{ old($name, $value ?? '') }}">

    </div>
</div>
@error('{{ $name }}')
    <p class="text-danger">*{{ $message }}</p>
@enderror