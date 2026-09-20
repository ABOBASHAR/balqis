<div class="form-group">
    <x-form.input id="name" name="name" label="اسم الموظف" placeholder="أدخل اسم الموظف"
        value="{{ $employee->name ?? old('name') }}" />
</div>
<div class="form-group">
    <x-form.input id="email" name="email" label="البريد الإلكتروني" placeholder="أدخل البريد الإلكتروني"
        value="{{ $employee->email ?? old('email') }}" />
</div>
<div class="form-group">
    <x-form.input id="phone" name="phone" label="رقم الهاتف" placeholder="أدخل رقم الهاتف"
        value="{{ $employee->phone ?? old('phone') }}" />
</div>
<div class="form-group">
    <x-form.select label="القسم" name="department_id" :options="$departments" :disabled="$departmentStatuses->map(fn ($status) => $status === 'inactive')->all()"
        :selected="$employee->department_id ?? null" />
    @if ($departmentStatuses->contains('inactive'))
        <small class="form-text text-danger "><i class="fas fa-exclamation-triangle"></i> الأقسام غير النشطة غير متاحة للاختيار.</small>
    @endif
</div>
<div class="form-group">
    <x-form.input id="job_title" name="job_title" label="عنوان الوظيفة" placeholder="أدخل عنوان الوظيفة"
        value="{{ $employee->job_title ?? old('job_title') }}" />
</div>
<div class="form-group">
    <x-form.input id="hire_date" name="hire_date" label="تاريخ التوظيف" placeholder="أدخل تاريخ التوظيف"
        value="{{ $employee->hire_date?->format('Y-m-d') ?? old('hire_date') }}" type="date" />
    {{-- value="{{ old('hire_date', $employee->getRawOriginal('hire_date')) }}" --}}
</div>
<div class="form-group">
    <x-form.input id="salary" name="salary" label="الراتب" placeholder="أدخل الراتب"
        value="{{ $employee->salary ?? old('salary') }}" type="number" />
</div>
<div class="form-group">
    <x-form.select label="حالة الموظف" name="status" :options="[
        'active' => 'نشط',
        'on_leave' => 'في إجازة',
        'terminated' => 'تم إنهاء الخدمة',
        'inactive' => 'غير نشط',
    ]" :selected="$employee->status ?? 'active'" />
</div>
<div class="form-group">
    <x-form.textarea id="address" name="address" label="العنوان" placeholder="أدخل العنوان"
        value="{{ $employee->address ?? old('address') }}" />
</div>
<div class="form-group">
    <x-form.textarea id="notes" name="notes" label="ملاحظات" placeholder="أدخل ملاحظات"
        value="{{ $employee->notes ?? old('notes') }}" />
</div>
