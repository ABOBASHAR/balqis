@php
    $deductionTypeLabels = [
        '' => 'الكل',
        'late' => 'خصم تأخير',
        'absent' => 'خصم غياب',
        'loan' => 'خصم قرض',
        'penalty' => 'خصم مخالفات',
        'tax' => 'خصم ضريبة',
        'other' => 'خصم آخر',
    ];
@endphp
@extends('layouts.dashboard.index')

@section('title', 'الموارد البشرية - تفاصيل الخصم')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list-alt ml-2"></i>
                تفاصيل الخصم
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
                    <td>{{ $deduction->id }}</td>
                </tr>
                <tr>
                    <th>اسم الموظف</th>
                    <td>{{ $deduction->employee->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>عنوان الخصم</th>
                    <td>{{ $deduction->title ?? '-' }}</td>
                </tr>
                <tr>
                    <th> نوع الخصم</th>
                    <td>{{ $deductionTypeLabels[$deduction->type] ?? '-' }}</td>
                </tr>
                <tr>
                    <th> مبلغ الخصم</th>
                    <td>{{ $deduction->amount ?? '-' }}</td>
                </tr>
                <tr>
                    <th> تاريخ الطلب</th>
                    <td>{{ $deduction->created_at }}</td>
                </tr>
                <tr>
                    <th> ملاحظات</th>
                    <td>{{ $deduction->notes ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <a href="{{ route('dashboard.hr.deductions.index') }}" class="btn btn-primary">
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
