@extends('layouts.dashboard.index')

@section('title','الموارد البشرية - تعديل طلب الإجازة')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit ml-2"></i>
                تعديل طلب الإجازة
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.hr.leaves.update', $leave->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('dashboard.pages.hr.leaves._form')
                <button type="submit" class="btn btn-primary">حفظ طلب الإجازة</button>
            </form>
        </div>
    </div>
@endsection
