<div class="card-body">
    <div class="form-group">
        <x-form.select id="employee_id" name="employee_id" label="الموظف" :options="$employees" :selected="$payroll->employee_id ?? old('employee_id')" />
    </div>
    <div class="form-group">
        <x-form.input name="period" type="month" label="شهر" placeholder="" :value="old('period', $payroll->exists ? $payroll->period() : now()->format('Y-m'))" />
    </div>
    <div class="form-group">
        <x-form.textarea name="notes" label="ملاحظات" placeholder="أدخل ملاحظات" rows="3"
            :value="$payroll->notes" />
    </div>
</div>
