@php
    $bonusTypeLabels = [
        'performance' => 'مكافأة أداء',
        'overtime' => 'مكافأة ساعات إضافية',
        'holiday' => 'مكافأة عطلة',
        'commission' => 'مكافأة عمولة',
        'other' => 'مكافأة أخرى',
    ];
@endphp
@extends('layouts.dashboard.index')

@section('title', 'الموارد البشرية - مكافآت الموظفين')

@section('content')

    <x-flash-message />
    @include('dashboard.pages.hr._menu', ['current' => 'bonuses'])
    <form action="{{ URL::current() }}" method="get" class="row m-2 g-3 align-itmes-end m-2 mt-3">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" placeholder="بحث عن موظف..."
                value="{{ request()->query('name') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">الكل</option>
                <option value="active" {{ request()->query('status') === 'active' ? 'selected' : '' }}>نشط</option>
                <option value="inactive" {{ request()->query('status') === 'inactive' ? 'selected' : '' }}>غير نشط</option>
            </select>
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
                قائمة المكافآت
            </h3>
            <div class="card-tools">
                <a href="{{ route('dashboard.hr.bonuses.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus ml-1"></i> إنشاء مكافأة جديدة
                </a>

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-bordered table-striped table-hover table-brown"
                    style="width: max-content; min-width: 100%; white-space: nowrap;">
                    <thead>
                        <tr>
                            <th class="col-id">#</th>
                            <th>اسم الموظف</th>
                            <th>نوع المكافأة</th>
                            <th>المبلغ</th>
                            <th>تاريخ المكافأة</th>
                            <th>تاريخ الطلب</th>
                            <th>ملاحظات</th>
                            <th>الإجراءات</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($bonuses as $bonus)
                            <tr>
                                <td>{{ $bonus->id }}</td>
                                <td><strong>{{ $bonus->employee->name }}</strong></td>
                                <td>{{ $bonusTypeLabels[$bonus->type] ?? $bonus->type }}</td>
                                <td>{{ $bonus->amount }}</td>
                                <td>{{ $bonus->date }}</td>
                                <td>{{ $bonus->created_at }}</td>
                                <td>{{ $bonus->notes }}</td>
                                <td>
                                    <a href="{{ route('dashboard.hr.bonuses.show', $bonus->id) }}"
                                        class="btn btn-primary btn-action" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dashboard.hr.bonuses.edit', $bonus->id) }}"
                                        class="btn btn-warning btn-action" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.hr.bonuses.destroy', $bonus->id) }}" method="POST"
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
            window.location.href = "{{ route('dashboard.hr.departments.index') }}";
        });
    </script>
@endpush
