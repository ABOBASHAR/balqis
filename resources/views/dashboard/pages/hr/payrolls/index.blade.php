@php
    $payrollStatusLabels = [
        '' => 'الكل',
        'paid' => 'مدفوع',
        'draft' => 'مسودة',
        'rejected' => 'مرفوض',
    ];
@endphp
@extends('layouts.dashboard.index')

@section('title', 'الموارد البشرية - رواتب الموظفين')

@section('content')

    <x-flash-message />
    @include('dashboard.pages.hr._menu', ['current' => 'payrolls'])
    <form action="{{ URL::current() }}" method="get" class="row m-2 g-3 align-itmes-end m-2 mt-3">
        <div class="col-md-3">
            <x-form.select name="employee_id" label="اسم الموظف" class="form-control" placeholder="" :options="$employees->prepend('الكل', '')"
                :selected="request()->query('employee_id')" />
        </div>
        <div class="col-md-3">
            <x-form.select name="status" label="حالة الراتب" class="form-control" :options="$payrollStatusLabels" :value="request()->query('status')"
                :selected="request()->query('status')" />
        </div>
        <div class="col-md-3">
            <x-form.input name="amount" label="المبلغ $" class="form-control" :value="request()->query('amount')" type="number" />
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">بحث
                <i class="fas fa-search ms-2"></i>
            </button>
            <button type="reset" class="btn btn-danger" id="resetBtn">إعادة تعيين
                <i class="fas fa-undo ms-2"></i>
            </button>
        </div>
    </form>
    <!-- الجدول -->
    <div class="card table-card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list-alt ml-2"></i>
                قائمة الرواتب
            </h3>
            <div class="card-tools">
                <a href="{{ route('dashboard.hr.payrolls.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus ml-1"></i> إنشاء راتب جديد
                </a>

            </div>
        </div>
        <div class="card-body">
            <table id="usersTable" class="table table-bordered table-striped table-hover table-brown"
                style="width: max-content; min-width: 100%; white-space: nowrap;">
                <thead>
                    <tr>
                        <th class="col-id">#</th>
                        <th>اسم الموظف</th>
                        <th>الشهر</th>
                        <th>الراتب الأساسي</th>
                        <th>المكافآت</th>
                        <th>الخصومات</th>
                        <th>الصافي</th>
                        <th>الحالة</th>
                        <th>ملاحظات</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payrolls as $payroll)
                        <tr>
                            <td>{{ $payroll->id }}</td>
                            <td><strong>{{ $payroll->employee->name }}</strong></td>
                            <td>{{ $payroll->month }}</td>
                            <td>{{ $payroll->base_salary }}</td>
                            <td>{{ $payroll->total_bonuses }}</td>
                            <td>{{ $payroll->total_deductions }}</td>
                            <td>{{ $payroll->net_salary }}</td>
                            <td>{{ $payrollStatusLabels[$payroll->status] ?? $payroll->status }}</td>
                            <td>{{ $payroll->notes ?? '-'}}</td>
                            <td>
                                <a href="{{ route('dashboard.hr.payrolls.show', $payroll->id) }}"
                                    class="btn btn-primary btn-action" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dashboard.hr.payrolls.edit', $payroll->id) }}"
                                    class="btn btn-warning btn-action" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.hr.payrolls.destroy', $payroll->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-action" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('dashboard/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script>
        $('#usersTable').DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            order: [
                [0, 'asc']
            ],
            language: {
                search: 'بحث:',
                lengthMenu: 'عرض _MENU_ سجل',
                info: 'عرض _START_ إلى _END_ من _TOTAL_ سجل',
                infoEmpty: 'لا توجد سجلات',
                infoFiltered: '(تمت التصفية من _MAX_ سجل)',
                zeroRecords: 'لم يتم العثور على نتائج',
                paginate: {
                    first: 'الأول',
                    last: 'الأخير',
                    next: 'التالي',
                    previous: 'السابق'
                }
            }
        });
    </script>
    <script>
        document.getElementById('resetBtn').addEventListener('click', function() {
            // Reset Process across clearing the input fields and select dropdowns
            window.location.href = "{{ route('dashboard.hr.payrolls.index') }}";
        });
    </script>
@endpush
