@props([
    'id' => null,
    'name',
    'label' => '',
    'placeholder' => '',
    'value' => '',
    'rows' => 4,
])
<label for="{{ $id ?? $name }}" class="form-label">{{ $label }}</label>
<textarea name="{{ $name }}" id="{{ $id ?? $name }}" rows="{{ $rows }}"
    class="form-control @error($name) is-invalid @enderror"
    placeholder="{{ $placeholder }}">{{ old($name, $value) }}</textarea>
@error($name)
    <div class="text-danger mt-2">
        {{ $message }}
    </div>
@enderror
