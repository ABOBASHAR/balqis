@extends('layouts.dashboard.index')

@section('content')
    <!-- إحصائيات سريعة -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-box">
                <div class="stat-icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">128</div>
                    <div class="stat-label">إجمالي المنتجات</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-box">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">96</div>
                    <div class="stat-label">نشط</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-box">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">22</div>
                    <div class="stat-label">قيد الانتظار</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-box">
                <div class="stat-icon">
                    <i class="fas fa-ban"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">10</div>
                    <div class="stat-label">موقوف</div>
                </div>
            </div>
        </div>
    </div>
    <x-flash-message />
    <form action="{{ URL::current() }}" method="get" class="row m-2 g-3 align-itmes-end m-2 mt-3">
        <div class="col-md-4">
            <x-form.input id="name" name="name" label="الاسم" placeholder="بحث عن منتج..."
            {{--value="{{ request('name') }}"    --}}
                value="{{ request()->query('name') }}" />
        </div>
        <div class="col-md-2">
            <x-form.select label="الحالة" name="status" class="form-control"
            :options="[
                '' => 'الكل',
                'active' => 'نشط',
                'inactive' => 'غير نشط',
            ]" 
            :selected="request()->query('status')" />
        </div>
        <div class="col-md-2">
            <x-form.select label="الفئة" class="col-md-2" name="category_id" 
            :options="$categories->prepend('كل الفئات', '')"
            :selected="request()->query('category_id','')" />
        </div>
        <div class="col-md-2">
            <x-form.select label="المتجر" name="store_id" 
            :options="$stores->prepend('كل المتاجر', '')" 
            :selected="request()->query('store_id','')" />
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
                قائمة المنتجات
            </h3>
            <div class="card-tools">
                <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus ml-1"></i> إضافة منتج جديد
                </a>

            </div>
        </div>
        <div class="card-body">
            <table id="usersTable" class="table table-bordered table-striped table-hover table-brown" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المنتج</th>
                        <th>اسم الفئة</th>
                        <th>اسم المتجر</th>
                        <th>الوصف</th>
                        <th>الحالة</th>
                        <th>السعر</th>
                        <th>تاريخ التسجيل</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->store->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>
                                @if ($product->status === 'active')
                                    <span class="badge badge-success">نشط</span>
                                @else
                                    <span class="badge badge-danger">غير نشط</span>
                                @endif
                            </td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('dashboard.products.show', $product->id) }}"
                                    class="btn btn-primary btn-action" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dashboard.products.edit', $product->id) }}"
                                    class="btn btn-warning btn-action" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="POST"
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
@push('styles')
    <style>

    </style>
@endpush

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
    <script>
        document.getElementById('resetBtn').addEventListener('click', function() {
            // Reset Process across clearing the input fields and select dropdowns
            window.location.href = "{{ route('dashboard.products.index') }}";
        });
    </script>
@endpush
