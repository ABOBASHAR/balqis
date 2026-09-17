<div class="form-group">
    {{-- <label for="name">اسم الفئة</label>
    <input type="text" class="form-control
        @error('name')
            is-invalid
        @enderror "
        name="name" value="{{ $category->name ?? old('name') }}" id="name" placeholder="أدخل اسم الفئة">
    @error('name')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror --}}
    <x-form.input id="name" name="name" label="اسم الفئة" placeholder="أدخل اسم الفئة" value="{{ $category->name ?? old('name') }}" />
</div>
<div class="form-group">
    <label for="description">وصف الفئة</label>
    <textarea name="description" id="description" class="form-control 
    @error('description')
        is-invalid
    @enderror
    " rows="4" placeholder="أدخل وصف الفئة">
                        {{ $category->description ?? old('description') }}
                    </textarea>
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
        'active' => 'Active',
        'inactive' => 'Inactive'
        ]"
    :selected="$category->status??'active'"
    />
</div>
