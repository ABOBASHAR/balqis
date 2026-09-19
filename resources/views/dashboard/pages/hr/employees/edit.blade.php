@extends('layouts.dashboard.index')

@section('title','الموارد البشرية - تعديل موظف')

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
                تعديل الموظف
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.hr.employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('dashboard.pages.hr.employees._form')
                <button type="submit" class="btn btn-primary">حفظ الموظف</button>
            </form>
        </div>
    </div>
@endsection
