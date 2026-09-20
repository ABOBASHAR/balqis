<div class="card-body">
    <div class="form-group">
        <x-form.select id="employee_id" name="employee_id" label="الموظف" :options="$employees" :selected="$bonus->employee_id ?? old('employee_id')" />
    </div>
    <div class="form-group">
        <x-form.input name="title" label="عنوان المكافأة" placeholder="أدخل عنوان المكافأة"
            value="{{ $bonus->title ?? old('title') }}" />
    </div>
    <div class="form-group">
        <x-form.select label="نوع المكافأة" name="type" :options="[
            'performance' => 'مكافأة أداء',
            'overtime' => 'مكافأة ساعات إضافية',
            'holiday' => 'مكافأة عطلة',
            'commission' => 'مكافأة عمولة',
            'other' => 'مكافأة أخرى',
        ]" :selected="$bonus->type ?? old('type')" />
    </div>

    <div class="form-group">
        <x-form.input name="amount" label="قيمة المكافأة" placeholder="أدخل قيمة المكافأة"
            value="{{ $bonus->amount ?? old('amount') }}" type="number" />
    </div>
    <div class="form-group">
        <x-form.input name="date" label="تاريخ المكافأة" placeholder=""
            value="{{ $bonus->date ?? old('date') }}" type="date" />
    </div>
    <div class="form-group">
        <x-form.textarea name="notes" label="ملاحظات" placeholder="أدخل ملاحظات" rows="3"
            value="{{ $bonus->notes ?? old('notes') }}" />
    </div>
</div>
