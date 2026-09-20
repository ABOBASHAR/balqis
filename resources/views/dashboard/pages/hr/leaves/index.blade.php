@php
    $statusLabels = [
        '' => 'الكل',
        'pending' => 'قيد الانتظار',
        'approved' => 'تمت الموافقة',
        'rejected' => 'تم رفضها',
    ];
    $statusClasses = [
        'pending' => 'badge-warning',
        'approved' => 'badge-success',
        'rejected' => 'badge-danger',
    ];
    $LeaveTypeLabels = [
        '' => 'الكل',
        'annual' => 'إجازة سنوية',
        'sick' => 'إجازة مرضية',
        'unpaid' => 'إجازة غير مدفوعة',
        'emergency' => 'إجازة طوارئ',
    ];
@endphp
@extends('layouts.dashboard.index')

@section('title', 'الموارد البشرية - طلبات الإجازة')

@section('content')

    <x-flash-message />
    @include('dashboard.pages.hr._menu', ['current' => 'leaves'])
    <form action="{{ URL::current() }}" method="get" class="row m-2 g-3 align-itmes-end m-2 mt-3">
        <div class="col-md-3">
            <x-form.select name="employee_id" label="اسم الموظف" :options="$employees->prepend('الكل', '')" class="form-control" placeholder="" :value="request()->query('employee_id')"
                :selected="request()->query('employee_id')" />
        </div>
        <div class="col-md-3">
            <x-form.select name="type" label="نوع الإجازة" class="form-control" :options="$LeaveTypeLabels"
            :value="request()->query('type')" 
            :selected="request()->query('type')" />
        </div>
        <div class="col-md-3">
            <x-form.select name="status" label="حالة الإجازة" class="form-control" :options="$statusLabels"
            :value="request()->query('status')" 
            :selected="request()->query('status')" />
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
                قائمة طلبات الإجازة
            </h3>
            <div class="card-tools">
                <a href="{{ route('dashboard.hr.leaves.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus ml-1"></i> إنشاء طلب إجازة جديد
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
                            <th>نوع الإجازة</th>
                            <th>تاريخ البداية</th>
                            <th>تاريخ النهاية</th>
                            <th>عدد الأيام</th>
                            <th>الحالة</th>
                            <th>السبب</th>
                            <th>الإجراءات</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($leaves as $leave)
                            <tr>
                                <td>{{ $leave->id }}</td>
                                <td><strong>{{ $leave->employee->name }}</strong></td>
                                <td>{{ $LeaveTypeLabels[$leave->type] ?? $leave->type }}</td>
                                <td>{{ $leave->start_date }}</td>
                                <td>{{ $leave->end_date }}</td>
                                <td>{{ $leave->days }}</td>
                                <td>
                                    <span class="badge {{ $statusClasses[$leave->status] ?? 'badge-secondary' }}">
                                        {{ $statusLabels[$leave->status] ?? $leave->status }}
                                    </span>
                                </td>
                                <td>{{ $leave->reason }}</td>
                                <td>
                                    <a href="{{ route('dashboard.hr.leaves.show', $leave->id) }}"
                                        class="btn btn-primary btn-action" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dashboard.hr.leaves.edit', $leave->id) }}"
                                        class="btn btn-warning btn-action" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if ($leave->status === 'pending')
                                        <form action="{{ route('dashboard.hr.leaves.approve', $leave->id) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-action" title="الموافقة">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('dashboard.hr.leaves.reject', $leave->id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-action" title="رفض">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('dashboard.hr.leaves.destroy', $leave->id) }}" method="POST"
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
            window.location.href = "{{ route('dashboard.hr.leaves.index') }}";
        });
    </script>
@endpush
