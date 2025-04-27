<div class="form-group {{ $class ?? '' }}">
    <label class="col-sm-2 col-form-label">{{ $label ?? 'Campo' }}:</label>
    <div class="col-sm-10">
        <textarea class="form-control" rows="3" name="{{ $name }}" placeholder="{{ $placeholder ?? 'Texto...' }}"
        @if (isset($id)) id="{{ $id }}" @endif> {{ old($name, $value ?? '') }} </textarea>
    </div>
</div>
@if ($errors->has($name))
    <div class="alert alert-danger mt-2">
        {{ $errors->first($name) }}
    </div>
@endif