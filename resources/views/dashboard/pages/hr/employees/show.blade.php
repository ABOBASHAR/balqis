@php
    $statusLabels = [
        'active' => 'نشط',
        'on_leave' => 'في إجازة',
        'terminated' => 'تم إنهاء الخدمة',
        'inactive' => 'غير نشط',
    ];
    
@endphp
@extends('layouts.dashboard.index')

@section('title','الموارد البشرية - تفاصيل الموظف')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list-alt ml-2"></i>
                تفاصيل الموظف
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>اسم الموظف</th>
                    <td>{{ $employee->name }}</td>
                </tr>
                <tr>
                    <th>البريد الإلكتروني</th>
                    <td>{{ $employee->email }}</td>
                </tr>
                <tr>
                    <th> رقم الهاتف</th>
                    <td>{{ $employee->phone }}</td>
                </tr>
                <tr>
                    <th> القسم</th>
                    <td>{{ $employee->department->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th> المسمى الوظيفي</th>
                    <td>{{ $employee->job_title ?? '-' }}</td>
                </tr>
                <tr>
                    <th> تاريخ التوظيف</th>
                    {{-- @php 
                    if($employee->hire_date != null)
                        $employee->hire_date = $employee->hire_date->format('Y-m-d');
                    else 
                    $employee->hire_date = null
                        
                    @endphp  --}}
                    {{-- <td>{{ $employee->hire_date == null ? '-' : $employee->hire_date }}</td> --}}
                    <td>{{ $employee->hire_date?->format('Y-m-d') ?? '-' }}</td>
                </tr>
                <tr>
                    <th> الراتب</th>
                    <td>{{ $employee->salary ?? '-' }}</td>
                </tr>
                <tr>
                    <th> الحالة</th>
                    <td>{{ $statusLabels[$employee->status] ?? '-' }}</td>
                </tr>
                <tr>
                    <th> العنوان</th>
                    <td>{{ $employee->address ?? '-' }}</td>
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
