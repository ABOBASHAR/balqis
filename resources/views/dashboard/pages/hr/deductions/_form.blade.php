<div class="card-body">
    <div class="form-group">
        <x-form.select id="employee_id" name="employee_id" label="الموظف" :options="$employees" :selected="$deduction->employee_id ?? old('employee_id')" />
    </div>
    <div class="form-group">
        <x-form.input name="title" label="عنوان الخصم" placeholder="أدخل عنوان الخصم"
            value="{{ $deduction->title ?? old('title') }}" />
    </div>
    <div class="form-group">
        <x-form.select label="نوع الخصم" name="type" :options="[
            'late' => 'خصم تأخير',
            'absent' => 'خصم غياب',
            'loan' => 'خصم قرض',
            'penalty' => 'خصم مخالفات',
            'tax' => 'خصم ضريبة',
            'other' => 'خصم آخر',
        ]" :selected="$deduction->type ?? old('type')" />
    </div>

    <div class="form-group">
        <x-form.input name="amount" label="قيمة الخصم" placeholder="أدخل قيمة الخصم"
            value="{{ $deduction->amount ?? old('amount') }}" type="number" />
    </div>
    <div class="form-group">
        <x-form.input name="date" label="تاريخ الخصم" placeholder="" value="{{ $deduction->date ?? old('date') }}"
            type="date" />
    </div>
    <div class="form-group">
        <x-form.textarea name="notes" label="ملاحظات" placeholder="أدخل ملاحظات" rows="3"
            value="{{ $deduction->notes ?? old('notes') }}" />
    </div>
</div>
