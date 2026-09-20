<div class="card-body">
    <div class="form-group">
        <x-form.select id="employee_id" name="employee_id" label="الموظف" :options="$employees" :selected="$leave->employee_id ?? old('employee_id')" />
    </div>
    <div class="form-group">
        <x-form.select label="نوع الإجازة" name="type" :options="[
            'annual' => 'إجازة سنوية',
            'sick' => 'إجازة مرضية',
            'unpaid' => 'إجازة غير مدفوعة',
            'emergency' => 'إجازة طوارئ',
        ]" :selected="$leave->type ?? 'pending'" />
    </div>

    <div class="form-group">
        <x-form.input id="start_date" name="start_date" label="تاريخ بدء الإجازة" placeholder=""
            value="{{ $leave->start_date ?? old('start_date') }}" type="date" />
    </div>
    <div class="form-group">
        <x-form.input id="end_date" name="end_date" label="تاريخ انتهاء الإجازة" placeholder=""
            value="{{ $leave->end_date ?? old('end_date') }}" type="date" />
    </div>
    <div class="form-group">
        <x-form.textarea id="reason" name="reason" label="سبب الإجازة" placeholder="أدخل سبب الإجازة" rows="3"
            value="{{ $leave->reason ?? old('reason') }}" />
    </div>
</div>
