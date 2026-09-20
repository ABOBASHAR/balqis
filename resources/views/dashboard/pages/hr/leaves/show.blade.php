@php
    $LeaveTypeLabels = [
        'annual' => 'إجازة سنوية',
        'sick' => 'إجازة مرضية',
        'unpaid' => 'إجازة غير مدفوعة',
        'emergency' => 'إجازة طوارئ',
    ];
    $statusLabels = [
        'pending' => 'قيد الانتظار',
        'approved' => 'تمت الموافقة',
        'rejected' => 'تم رفضها',
    ];
@endphp
@extends('layouts.dashboard.index')

@section('title', 'الموارد البشرية - تفاصيل طلب الإجازة')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list-alt ml-2"></i>
                تفاصيل طلب الإجازة
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
                    <td>{{ $leave->id }}</td>
                </tr>
                <tr>
                    <th>اسم الموظف</th>
                    <td>{{ $leave->employee->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th> نوع الإجازة</th>
                    <td>{{ $LeaveTypeLabels[$leave->type] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>تاريخ البداية</th>
                    <td>{{ $leave->start_date }}</td>
                </tr>
                <tr>
                    <th>تاريخ النهاية</th>
                    <td>{{ $leave->end_date }}</td>
                </tr>
                <tr>
                    <th> عدد الأيام</th>
                    <td>{{ $leave->days }}</td>
                </tr>
                <tr>
                    <th> الحالة</th>
                    <td>{{ $statusLabels[$leave->status] ?? '-' }}</td>
                </tr>
                <tr>
                    <th> تاريخ الطلب</th>
                    <td>{{ $leave->created_at }}</td>
                </tr>
                <tr>
                    <th> تاريخ التحديث</th>
                    <td>{{ $leave->updated_at }}</td>
                </tr>
                <tr>
                    <th>سبب الإجازة</th>
                    <td>{{ $leave->reason ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <a href="{{ route('dashboard.hr.leaves.index') }}" class="btn btn-primary">
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
