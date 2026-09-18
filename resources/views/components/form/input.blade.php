@props(
    ['id',
    'name',
    'type' => 'text',
    'label' => '',
    'placeholder' => '',
    'value' => '',
])
<label for="{{ $id ?? $name }}" class="form-label">{{ $label }}</label>
<input type="{{ $type }}" name="{{ $name }}" id="{{ $id ?? $name }}"
    class="form-control @error($name) is-invalid @enderror"
    placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}">
@error($name)
    <div class="text-danger mt-2">
        {{ $message }}
    </div>
@enderror