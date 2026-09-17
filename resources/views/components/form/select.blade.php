@props([
    'label',
    'name',
    'options' => [],
    'selected',  
])
<label for="{{ $name }}" class="form-label">{{ $label ?? '' }}</label>
<select name="{{ $name }}" id="{{ $name }}" class="form-control mb-3 
    @error($name)
        is-invalid
    @enderror
    ">
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" 
            {{ $value == old($name, $selected) ? 'selected' : '' }}
            {{-- this (line 15) or that (line 17 --> 19</option>) --}}
            {{-- @if ($value == old($name, $selected))
                selected
            @endif --}}
            >
                {{ $text }}</option>
        @endforeach
    </select>
    @error($name)
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror