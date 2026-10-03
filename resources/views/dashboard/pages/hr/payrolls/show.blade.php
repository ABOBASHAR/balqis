@php
    $payrollStatusLabels = [
        '' => 'الكل',
        'paid' => 'مدفوع',
        'draft' => 'مسودة',
        'rejected' => 'مرفوض',
    ];
@endphp
@extends('layouts.dashboard.index')

@section('title', 'الموارد البشرية - تفاصيل الراتب')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list-alt ml-2"></i>
                تفاصيل الراتب
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered" style="table-layout: fixed; width: 100%;">
                <colgroup>
                    <col style="width: 50%;">
                    <col style="width: 50%;">
                </colgroup>
                <tr>
                    <th>رقم الطلب</th>
                    <td>{{ $payroll->id }}</td>
                </tr>
                <tr>
                    <th>اسم الموظف</th>
                    <td>{{ $payroll->employee->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th> الشهر</th>
                    <td>{{ $payroll->month ?? '-' }}</td>
                </tr>
                <tr>
                    <th>الراتب الأساسي</th>
                    <td>{{ $payroll->base_salary ?? 0 }}</td>
                </tr>
                <tr>
                    <th>المكافآت</th>
                    <td>{{ $payroll->total_bonuses ?? 0 }}</td>
                </tr>
                <tr>
                    <th>الخصومات</th>
                    <td>{{ $payroll->total_deductions ?? 0 }}</td>
                </tr>
                <tr>
                    <th> الصافي</th>
                    <td>{{ $payroll->net_salary ?? 0 }}</td>
                </tr>
                <tr>
                    <th> الحالة</th>
                    <td>{{ $payrollStatusLabels[$payroll->status] ?? '-' }}</td>
                </tr>
                <tr>
                    <th> الملاحظات</th>
                    <td>{{ $payroll->notes ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <a href="{{ route('dashboard.hr.payrolls.index') }}" class="btn btn-primary">
                            الرجوع <i class="fas fa-undo"></i>
                        </a>
                    </td>
                </tr>

            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('dashboard/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script>
        $(function() {
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
        });
    </script>
@endpush
