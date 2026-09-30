@extends('layouts.dashboard.index')

@section('title','الموارد البشرية - إنشاء خصم')

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
                <i class="fas fa-plus ml-2"></i>
                إنشاء خصم جديد
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.hr.deductions.store') }}" method="POST">
                @csrf
                @method('POST')
                @include('dashboard.pages.hr.deductions._form')
                <button type="submit" class="btn btn-primary">حفظ الخصم</button>
            </form>
        </div>
    </div>
@endsection
