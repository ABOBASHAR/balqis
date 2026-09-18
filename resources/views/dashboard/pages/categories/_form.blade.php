<div class="form-group">
    <x-form.input id="name" name="name" label="اسم الفئة" placeholder="أدخل اسم الفئة" value="{{ $category->name ?? old('name') }}" />
</div>
<div class="form-group">
    <label for="description">وصف الفئة</label>
    <textarea name="description" id="description" class="form-control 
    @error('description')
        is-invalid
    @enderror
    " rows="4" placeholder="أدخل وصف الفئة">{{ $category->description ?? old('description') }}</textarea>
    @error('description')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="form-group">
    <x-form.select 
    label="حالة الفئة"
    name="status"
    :options="[
        'active' => 'نشط',
        'inactive' => 'غير نشط'
        ]"
    :selected="$category->status??'active'"
    />
</div>
