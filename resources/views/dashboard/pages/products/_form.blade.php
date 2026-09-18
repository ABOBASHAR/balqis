<div class="form-group">
    <x-form.input id="name" name="name" label="اسم المنتج" placeholder="أدخل اسم المنتج"
        value="{{ $product->name ?? old('name') }}" />
</div>
<div class="form-group">
    <label for="description">وصف المنتج</label>
    <textarea name="description" id="description"
        class="form-control 
    @error('description')
        is-invalid
    @enderror
    " rows="4"
        placeholder="أدخل وصف المنتج">{{ $product->description ?? old('description') }}</textarea>
</div>
<div class="form-group">
    <x-form.input id="name" type="number" name="price" label="سعر المنتج" placeholder="أدخل سعر المنتج"
        value="{{ $product->price ?? old('price') }}" />
</div>
<div class="form-group">
    <x-form.select label="حالة المنتج" name="status" :options="[
        'active' => 'نشط',
        'inactive' => 'غير نشط',
    ]" :selected="$product->status ?? 'active'" />
</div>
<div class="form-group">
    <x-form.select label="الفئات" name="category_id" :options="$categories" :selected="$product->category_id ?? ''" />
</div>
<div class="form-group">
    <x-form.select label="المتاجر" name="store_id" :options="$stores" :selected="$product->store_id ?? ''" />
</div>
