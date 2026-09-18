<div class="form-group">
    <x-form.input id="name" name="name" label="اسم المتجر" placeholder="أدخل اسم المتجر"
        value="{{ $store->name ?? old('name') }}" />
</div>
<div class="form-group">
    <label for="description">وصف المتجر</label>
    <textarea name="description" id="description"
        class="form-control 
    @error('description')
        is-invalid
    @enderror
    " rows="4"
        placeholder="أدخل وصف المتجر">{{ $store->description ?? old('description') }}</textarea>
    @error('description')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="form-group">
    <x-form.select label="حالة المتجر" name="status" :options="[
        'active' => 'نشط',
        'inactive' => 'غير نشط',
    ]" :selected="$store->status ?? 'active'" />
</div>
