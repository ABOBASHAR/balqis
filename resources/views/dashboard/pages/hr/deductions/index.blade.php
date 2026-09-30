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

@section('title', 'الموارد البشرية - خصومات الموظفين')

@section('content')

    <x-flash-message />
    @include('dashboard.pages.hr._menu', ['current' => 'deductions'])
    <form action="{{ URL::current() }}" method="get" class="row m-2 g-3 align-itmes-end m-2 mt-3">
        <div class="col-md-3">
            <x-form.select name="employee_id" label="اسم الموظف" class="form-control" placeholder="" :options="$employees->prepend('الكل', '')"
                :selected="request()->query('employee_id')" />
        </div>
        <div class="col-md-3">
            <x-form.select name="type" label="نوع الخصم" class="form-control" :options="$deductionTypeLabels" :value="request()->query('type')"
                :selected="request()->query('type')" />
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
                قائمة الخصومات
            </h3>
            <div class="card-tools">
                <a href="{{ route('dashboard.hr.deductions.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus ml-1"></i> إنشاء خصم جديد
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
                        <th>عنوان الخصم</th>
                        <th>نوع الخصم</th>
                        <th>المبلغ</th>
                        <th>تاريخ الخصم</th>
                        <th>ملاحظات</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deductions as $deduction)
                        <tr>
                            <td>{{ $deduction->id }}</td>
                            <td><strong>{{ $deduction->employee->name }}</strong></td>
                            <td>{{ $deduction->title }}</td>
                            <td>{{ $deductionTypeLabels[$deduction->type] ?? $deduction->type }}</td>
                            <td>{{ $deduction->amount }}</td>
                            <td>{{ $deduction->date }}</td>
                            <td>{{ $deduction->notes }}</td>
                            <td>
                                <a href="{{ route('dashboard.hr.deductions.show', $deduction->id) }}"
                                    class="btn btn-primary btn-action" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dashboard.hr.deductions.edit', $deduction->id) }}"
                                    class="btn btn-warning btn-action" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.hr.deductions.destroy', $deduction->id) }}" method="POST"
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
            window.location.href = "{{ route('dashboard.hr.deductions.index') }}";
        });
    </script>
@endpush
